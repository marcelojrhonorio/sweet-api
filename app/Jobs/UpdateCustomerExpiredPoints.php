<?php

namespace App\Jobs;

use Log;
use Carbon\Carbon;
use App\Models\Customers;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerExpiredPoint;
use App\Jobs\CustomerExpiredPointsEmailJob;

class UpdateCustomerExpiredPoints extends Job
{
    private $timeout = 300;

    private $customerId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($customerId)
    {
        $this->customerId = $customerId;
        $this->customerId = (int) $this->customerId->id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        self::updateCustomerPoints($this->customerId);
    }

    private static function updateCustomerPoints (int $customerId) {
        
        $pointsSummary = self::getPointsSummary($customerId);

        $accumulatedPoints = 
            $pointsSummary['actions']['totalPoints'] + 
            $pointsSummary['incentiveEmails']['totalPoints'] +
            $pointsSummary['ssiResearches']['totalPoints'] + 
            $pointsSummary['researches']['totalPoints'] + 
            $pointsSummary['emailConfirmation']['totalPoints'] + 
            $pointsSummary['registration']['totalPoints'] + 
            $pointsSummary['memberGetMembers']['totalPoints'] +
            $pointsSummary['insuranceResearches']['totalPoints'];

        (int) $expiredPoints = $accumulatedPoints - $pointsSummary['exchanges']['totalPoints'];

        /**
         * Create instances.
         */
        $customerExpiredPoint = new CustomerExpiredPoint();
        $customer             = Customers::find($customerId);
        $customer->points     = (int) $customer->points; //make as integer.

        
        /**
         * Set customer expired points values.
         */
        $customerExpiredPoint->customers_id = $customerId;
        $customerExpiredPoint->expired_points = $expiredPoints;
        $customerExpiredPoint->previous_balance = $customer->points;
        $customerExpiredPoint->balance_after = ($customer->points - $expiredPoints) >= 0 ? ($customer->points - $expiredPoints) : 0;
        $customerExpiredPoint->expired_points_divergence = $expiredPoints < 0 ? $expiredPoints : 0;
        $customerExpiredPoint->points_balance_divergence = ($customer->points - $expiredPoints < 0) ? ($customer->points - $expiredPoints) : 0;
        $customerExpiredPoint->save();

        /**
         * Update Customer Points.
         */
        $customer->points = ($customer->points - $expiredPoints) < 0 ? 0 : ($customer->points - $expiredPoints);
        $customer->last_points_expiration_at = Carbon::now()->toDateTimeString();
        $customer->save();

        /**
         * Dispath Job if customer is confirmed.
         */
        if($customer->confirmed) {
            $job = (new CustomerExpiredPointsEmailJob($pointsSummary, $customerId, $customerExpiredPoint->id))->onQueue('customer_expired_points_email');
            dispatch($job);

            Log::debug('[EXPIRATION] Vai enviar o e-mail para ' . $customer->email . ' e id ' . $customer->id);
        }

    }

    private static function verifyActions (int $customerId) {
        $checkins =
            DB::select('
                SELECT c.created_at, c.points, a.title
                FROM sweet.checkins c
                    INNER JOIN sweet.actions a
                    ON c.actions_id = a.id 
                WHERE (customers_id =' . $customerId.') 
                    AND (DATEDIFF(now(), c.created_at) BETWEEN 366 AND 730)
                    AND points > 0;
                ');
        
        $points = 0;
        foreach ($checkins as $checkin) {
            $points += (int) $checkin->points;
            $checkin->created_at = self::parseBrDateFormat($checkin->created_at);
        }

        return  ['totalPoints' => $points, 'checkins' => $checkins];
    }

    private static function verifyIncentiveEmails (int $customerId) {
        $incentiveEmails = 
            DB::select('
                SELECT cie.created_at, ie.points, ie.title
                FROM sweet.incentive_emails ie 
                    INNER JOIN sweet.checkin_incentive_emails cie
                        ON ie.id = cie.incentive_emails_id
                    INNER JOIN sweet.customers c
                        ON cie.customers_id = c.id
                WHERE c.id =' . $customerId .'
                    AND (DATEDIFF(now(), cie.created_at) BETWEEN 366 AND 730)
                    AND ie.points > 0');

        $points = 0;
        foreach ($incentiveEmails as $incentiveEmail) {
            $points += (int) $incentiveEmail->points;
            $incentiveEmail->created_at = self::parseBrDateFormat($incentiveEmail->created_at);
        }

        return ['totalPoints' => $points,'incentiveEmails' => $incentiveEmails];
    }

    private static function verifySsi (int $customerId) {
        $ssiResearches = 
            DB::select('
                SELECT ssipr.created_at, ssipr.point
                FROM sweet.ssi_project_respondents ssipr
                    INNER JOIN sweet.customers c
                        ON ssipr.respondentId = c.id
                WHERE c.id =' . $customerId .'
                    AND (DATEDIFF(now(), ssipr.created_at) BETWEEN 366 AND 730)
                    AND ssipr.point > 0');

        $points = 0;
        foreach ($ssiResearches as $ssiResearch) {
            $points += (int) $ssiResearch->point;
            $ssiResearch->created_at = self::parseBrDateFormat($ssiResearch->created_at);
        }

        return ['totalPoints' => $points, 'ssiResearches' => $ssiResearches];
    }

    private static function verifyResearches (int $customerId) {
        $researches = 
            DB::select('
                SELECT cr.created_at, r.title, cr.points
                FROM sweet.researches r 
                	INNER JOIN sweet.checkin_researches cr
                		ON r.id = cr.researches_id
                	INNER JOIN sweet.customers c
                		ON cr.customers_id = c.id
                WHERE c.id =' . $customerId .'
                    AND (DATEDIFF(now(), cr.created_at) BETWEEN 366 AND 730)
                    AND cr.points > 0');

        $points = 0;
        foreach ($researches as $research) {
            $points += $research->points;
            $research->created_at = self::parseBrDateFormat($research->created_at);
        }

        return ['totalPoints' => $points, 'researches' => $researches];
    }

    private static function verifyConfirmationEmail (int $customerId) {
        $customer = Customers::find($customerId);

        $daysRegistration = self::getNumberDaysRegistration($customer->created_at);

        $c1 = (1 === (int) $customer->confirmed);
        $c2 = ($daysRegistration > 365 && $daysRegistration < 731);

        $points = ($c1 && $c2) ? 30 : 0;

        return [
                'totalPoints' => $points, 
                'confirmed' => (int) $customer->confirmed,
                'createdAt' => self::parseBrDateFormat($customer->created_at),
            ];
    }

    private static function verifyRegistration (int $customerId) {
        $customer = Customers::find($customerId);

        $daysRegistration = self::getNumberDaysRegistration($customer->created_at);

        $points = ($daysRegistration > 365 && $daysRegistration < 731) ? 50 : 0;

        return ['totalPoints' => $points, 'createdAt' => self::parseBrDateFormat($customer->created_at)];
    }

    private static function verifyMemberGetMembers (int $customerId) {
        $indications = 
            DB::select('
                SELECT *
                FROM sweet.customers
                WHERE (indicated_by =' . $customerId .')
                    AND confirmed = 1
                    AND ((confirmed_at is null) OR (confirmed_at is not null AND updated_personal_info_at is not null))
                    AND (DATEDIFF(now(), created_at) BETWEEN 366 AND 730)');

        foreach ($indications as $indication) {
            $indication->created_at = self::parseBrDateFormat($indication->created_at);
        }

        return [
                'totalPoints' => (sizeof($indications) * 10), 
                'customers' => $indications
            ];
    }

    private static function verifyInsuranceResearches (int $customerId) {
        $insuranceResearches = 
            DB::select('
                SELECT cr.id, customer_research_points, cr.created_at
                FROM sweet_seguro_auto.customer_researches cr
                    INNER JOIN sweet.customers c
                        ON cr.customer_id = c.id
                WHERE c.id =' . $customerId .'
                    AND (DATEDIFF(now(), cr.created_at) BETWEEN 366 AND 730)
                    AND cr.customer_research_points > 0');

        $points = 0;
        foreach ($insuranceResearches as $insuranceResearch) {
            $points += $insuranceResearch->customer_research_points;
            $insuranceResearch->created_at = self::parseBrDateFormat($insuranceResearch->created_at);
        }

        return ['totalPoints' => $points, 'insuranceResearches' => $insuranceResearches];
    }

    private static function verifyExchanges (int $customerId) {
        $exchangeds =
            DB::select('
                SELECT cep.points, ps.title, cep.created_at
                FROM sweet.customer_exchanged_points cep
                    INNER JOIN sweet.products_services ps
                        ON ps.id = cep.product_services_id
                    INNER JOIN sweet.customers c
                        ON cep.customers_id = c.id
                WHERE c.id =' . $customerId .'
                    AND (DATEDIFF(now(), cep.created_at) BETWEEN 366 AND 730)');

        $points = 0;
        foreach ($exchangeds as $exchanged) {
            $points += $exchanged->points;
            $exchanged->created_at = self::parseBrDateFormat($exchanged->created_at);
        }

        return ['totalPoints' => $points, 'exchangedPoints' => $exchangeds];
    }

    private static function getPointsSummary (int $customerId) {
        return [
            'actions' => self::verifyActions($customerId),
            'incentiveEmails' => self::verifyIncentiveEmails($customerId),
            'ssiResearches' => self::verifySsi($customerId),
            'researches' => self::verifyResearches($customerId),
            'emailConfirmation' => self::verifyConfirmationEmail($customerId),
            'registration' => self::verifyRegistration($customerId),
            'memberGetMembers' => self::verifyMemberGetMembers($customerId),
            'insuranceResearches' => self::verifyInsuranceResearches($customerId),
            'exchanges' => self::verifyExchanges($customerId),
        ];
    }

    private static function parseBrDateFormat (string $date) {
        $year  = substr($date, 0, 4);
        $month = substr($date, 5, 2);
        $day   = substr($date, 8, 2);

        return $day . '/' . $month . '/' . $year; 
    }

    private static function getNumberDaysRegistration (string $createdAt) {

        $createdAt = Carbon::parse($createdAt);
        $now       = Carbon::now();
        
        return (int) $createdAt->diffInDays($now);
    }
}
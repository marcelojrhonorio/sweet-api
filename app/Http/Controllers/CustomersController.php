<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use Carbon\Carbon;
use App\Models\Customers;
use Illuminate\Http\Request;
use App\Jobs\CustomerCreatedJob;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Queue;
use App\Models\CustomerAddress\CustomerAddress;


/**
 * @todo validar tag erro retorno json com códiog de erro 400
 * @todo erro 422 quando os dados não são processados
 *
 * Class CustomersController
 * @package App\Http\Controllers
 */
class CustomersController extends Controller
{
    private $rules = [
        'fullname'     => 'required|max:60',
        'email'        => 'unique:customers,email|required|max:200',
        'birthdate'    => 'required',
        'birthtime'    => 'required',
        'phone_number' => 'nullable|max:14',
    ];

    protected function customerValidator(Request $request) {
        $validator = Validator::make($request->all(), $this->rules);

        return $validator;
    }

    public function index(Request $request)
    {

        $companiesId = false;
        $campaignsId = false;

        if ($request->has('companies_id')) {
            $companiesId = $request->get('companies_id');
            $campaignsId = false;
        }

        if ($request->has('campaigns_id')) {
            $campaignsId = $request->get('campaigns_id');
            $companiesId = false;
        }

        $entity = Customers::select(
            'customers.*'
        );

        if ($companiesId) {
            $entity
                ->join('campaign_answers', 'customers.id', '=', 'campaign_answers.customers_id')
                ->join('campaigns', 'campaign_answers.campaigns_id', '=', 'campaigns.id')
                ->where('campaigns.companies_id', $companiesId)
                ->where('campaign_answers.answer', 'like', '%sim%');
        }

        if ($campaignsId) {
            $entity
                ->join('campaign_answers', 'customers.id', '=', 'campaign_answers.customers_id')
                ->where('campaign_answers.campaigns_id', $campaignsId)
                ->where('campaign_answers.answer', 'like', '%sim%');
        }

        $entity->distinct('customers.id')->orderBy('customers.id',' ASC');

        return response()->json([
            'results' => $entity->get(),
        ], 200);
    }

    public function updateReceiveOffers(int $id)
    {
        $customer  = Customers::find($id) ?? null;
        
        if(is_null($customer)) {
            return response()->json([
                'success'  => false,
                'errors'   => ['not_found' => 'Invalid Customer.'],
                'customer' => [],
            ], 404);
        }

        $customer->receive_offers = true;
        $customer->points = $customer->points + 60;
        $customer->update();

        return $customer;
    }

    public function getScheduleUpdatedInfo($id)
    {
        $customer  = Customers::find($id) ?? null;
        
        if($customer) {
            return response()->json([
                'success'  => true,
                'data'     => $customer->schedule_updated_personal_info_at,
            ]);
        }

        return response()->json([
            'success'  => false,
            'data'     => [],
        ]);
    }

    public function updateScheduleUpdatedInfo(Request $request)
    {
        $customers_id = $request->input('customers_id');
        $date = $request->input('date');
        
        $customer  = Customers::find($customers_id) ?? null;
        
        if($customer) {
            $customer->schedule_updated_personal_info_at = $date;
            $customer->update();

            return response()->json([
                'success'  => true,
                'data'     => $customer,
            ]);
        }

        return response()->json([
            'success'  => false,
            'data'     => [],
        ]);
    }

    public function findById($id)
    {  
        $customer  = Customers::find($id) ?? null;
        
        if (is_null($customer)) {
            return response()->json([
                'success'  => false,
                'errors'   => ['not_found' => 'Invalid Customer.'],
                'customer' => [],
            ], 404);
        }

        return response()->json([
            'success'  => true,
            'customer' => $customer,
        ], 200);        

    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function find(int $id)
    {
        $customer  = Customers::find($id);
        if (is_null($customer)) {
            throw new \Exception('Customer not found.');
        }

        return response()->json(['result' => $customer], 200);
    }

    private function generateToken()
    {
        return sha1(base64_encode(str_random(70)));
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function findByEmail(Request $request)
    {
        $customer = Customers::where('email', $request->input('email'))->first();

        $return = 0;
        $token = '';
        $id = '';
        $customerData = [];
        if (!is_null($customer)) {
            $id = $customer->id;
            $customerData = [
                'gender' => '',
                'ddd' => $customer->ddd,
                'phone' => $customer->phone_number,
                'cep' => $customer->cep,
                'birthdate' => $customer->birthdate,
                'changed_password' => $customer->changed_password,
            ];
            $token = $this->generateToken();
            $return = 1;
            $customer->token = $token;
            $customer->save();
        }

        return response()->json([
            'customer' => $id,
            'data'     => $customerData,
            'token'    => $token,
            'result'   => $return,
        ], 200);
    }

    /**
     * Create a new customer
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname'     => 'required',
            'email'        => 'required|email',
            'birthdate'    => 'required',
            'phone_number' => 'nullable|max:14',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], 422);
        }

        $customerDeleted = self::checkCustomerDeleted($request->input('email'));

        if ($customerDeleted) {
            return response()->json([
                'status' => 'email_deleted',
                'result' => [],
            ], 200);
        }

        $emailExists = Customers::where('email', $request->input('email'))->first();
        
        if ($emailExists) {
            return response()->json([
                'status' => 'email_exists',
                'result' => $emailExists,
            ], 200);
        }

        $token        = $this->generateToken();
        $passwordHash = Hash::make('sweetpass');
        
        $customer                           = new Customers();
        $customer->fullname                 = $request->input('fullname');
        $customer->email                    = $request->input('email');
        $customer->password                 = $passwordHash;
        $customer->gender                   = $request->input('gender') ?? '';
        $customer->birthdate                = $request->input('birthdate');
        $customer->birthtime                = $request->input('birthtime');
        $customer->state                    = $request->input('state');
        $customer->city                     = $request->input('city');
        $customer->cep                      = $request->input('cep') ?? '';
        $customer->cpf                      = $request->input('cpf') ?? '';
        $customer->ddd                      = $request->input('ddd') ?? '';
        $customer->phone_number             = $request->input('phone_number');
        $customer->source                   = $request->input('source') ?? '';
        $customer->medium                   = $request->input('medium') ?? '';
        $customer->campaign                 = $request->input('campaign') ?? '';
        $customer->term                     = $request->input('term') ?? '';
        $customer->content                  = $request->input('content') ?? '';
        $customer->token                    = $token;
        $customer->site_origin              = $request->input('site_origin');
        $customer->indicated_by             = $request->input('indicated_by');
        $customer->indicated_from           = $request->input('indicated_from');
        $customer->ip_address               = $request->input('ip_address') ?? '';
        $customer->confirmation_code        = str_random(30);
        $customer->invalid_cep              = $request->input('invalid_cep') ?? false;
        $customer->updated_by_cep           = $request->input('updated_by_cep') ?? false;
        $customer->updated_personal_info_at = $request->input('updated_personal_info_at') ?? null;
        $customer->confirmed_at             = $request->input('confirmed_at') ?? null;
        $customer->changed_password         = false;
        $customer->save();

        $headerLocation = sprintf('%s/%d', $request->url(), $customer->id);

        return response()->json([
            'status'   => 'success',
            'token'    => $token,
            'result'   => $customer,
            'password' => 'sweetpass',
        ], 201, ['Location' => $headerLocation]);
    }

    /**
     * Update the specified customer.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $customer  = Customers::find($id);
        
        $cpf = $request->input('cpf') ?? 'não informado';

        $cpfCondition1 = sizeof(Customers::where('cpf', $cpf)->get()) > 1;
        $cpfCondition2 = (sizeof(Customers::where('cpf', $cpf)->get()) == 1) && $customer->cpf != $cpf;

        if ($cpfCondition1 || $cpfCondition2) {
            return response()->json([
                'status'   => 'duplicated_cpf',
                'result'   => [],
            ]);
        }
        
        $customer->fullname = $request->input('fullname');
        $customer->email = $request->input('email');
        $customer->gender = $request->input('gender');
        $customer->birthdate = $request->input('birthdate');
        $customer->birthtime = $request->input('birthtime') ?? null;
        $customer->cep = $request->input('cep');
        $customer->state = $request->input('state') ?? '';
        $customer->city = $request->input('hometown') ?? 'Default';
        $customer->ddd = $request->input('ddd') ?? null;
        $customer->phone_number = $request->input('phone_number');
        $customer->secondary_phone_number = $request->input('secondary_phone_number') ?? null;
        $customer->cpf = $request->input('cpf') ?? '';
        $customer->points = $request->input('points');
        $customer->invalid_cep = $request->input('invalid_cep') ?? false;
        $customer->updated_by_cep = $request->input('updated_by_cep') ?? false;
        $customer->campaign_answers_at = $request->input('campaign_answers_at') ?? null;
        $customer->save();

        return response()->json([
            'status'   => 'success',
            'result'   => $customer,
        ], 201);
    }

    public function updateCustomerPoints(Request $request)
    {
        $id = $request->input('indicated_by');
        $points = $request->input('points');

        $customer = Customers::find($id);
        $customer->points = $customer->points + $points;
        $customer->save();

        return response()->json([
            'status'   => 'success',
            'result'   => $customer,
        ]);

    }

    public function verifyCustomerAvatar(Request $request)
    {
        $customers = Customers::whereNotNull('avatar')->get() ?? null;

        return $customers;
    }

    public function updateCustomerAvatar(Request $request)
    {
        $customers_id = $request->input('customers_id');
        $userIdAvatar = $request->input('userIdAvatar');

        $customer  = Customers::find($customers_id) ?? null;

        if($customer) {
            if($userIdAvatar) {
                $customer->avatar = 'https://graph.facebook.com/' . $userIdAvatar . '/picture?type=normal';
            } else {
                $customer->avatar = null;
            }

            $customer->update();
        }

        return $customer;
    }

    public function forwardingEmailSentVerify(Request $request)
    {
        $customers = Customers::where('forwarding_email_sent', '<>', 0)->get() ?? null;

        return $customers;
    }

    public function verifyForwardingEmailSent(Request $request)
    {
        $id = $request->input('customers_id');

        $customer = Customers::find($id) ?? null;

        return $customer->forwarding_email_sent;
    }

    public function resetForwardingEmailSent(Request $request)
    {
        $id = $request->input('customers_id');

        $customer = Customers::find($id);
        $customer->forwarding_email_sent = 0;
        $customer->update();

        return $customer;
    }

    public function updateForwardingEmailSent(Request $request)
    {
        $id = $request->input('customers_id');

        $customer = Customers::find($id);
        $customer->forwarding_email_sent = $customer->forwarding_email_sent + 1;
        $customer->update();

        return $customer->forwarding_email_sent;
    }

    public function updateSentStoreEmail(Request $request)
    {
        $id = $request->input('customers_id');

        $customer = Customers::find($id);
        $customer->sent_store_email_at = Carbon::now()->toDateTimeString();
        $customer->update();

        return response()->json([
            'status'   => 'success',
            'result'   => $customer,
        ]);
    }

    public function updateCustomerData(Request $request, $id)
    {
        $customer = Customers::find($id);
       
        $cpf = $request->input('cpf') ?? 'não informado';

        $cpfCondition1 = sizeof(Customers::where('cpf', $cpf)->get()) > 1;
        $cpfCondition2 = (sizeof(Customers::where('cpf', $cpf)->get()) == 1) && $customer->cpf != $cpf;

        if ($cpfCondition1 || $cpfCondition2) {
            return response()->json([
                'status'   => 'duplicated_cpf',
                'result'   => [],
            ]);
        }

        $firstUpdate = false;

        /**
         * Member Get Member Verification
         * 
         * The score of the seal will only be given 
         * if the indicated user confirms the email 
         * and if he has already updated his data 
         * for the first time (after the first time, 
         * the score will not be given).
         */
        $condition1 = $customer->indicated_by;
        $condition2 = null !== $customer->confirmed_at;
        $condition3 = null === $customer->updated_personal_info_at;

        $firstUpdate = ($condition1 && $condition2 && $condition3) ? true : false;

        $customer->fullname = $request->input('fullname');
        $customer->secondary_email = $request->input('email');
        $customer->birthdate = self::getBdayFormat($request->input('birthdate'));
        $customer->cpf = $request->input('cpf');
        $customer->cep = $request->input('cep');
        $customer->ddd = substr($request->input('phone1'), 1, 2);
        $customer->phone_number = self::getPhoneFormat($request->input('phone1'));         
        $customer->secondary_phone_number = $request->input('phone2') ?? null;
        $customer->updated_personal_info_at = Carbon::now()->toDateTimeString();

        if(env('PROFILE_PICTURE')) {
            $customer->avatar = $request->input('avatar');
        }
        
        $customer->save();

        return response()->json([
            'status'      => 'success',
            'firstUpdate' => $firstUpdate,            
            'result'      => $customer,
        ]);
    }

    private static function getBdayFormat($birthdate)
    {
        $bday = explode("/", $birthdate);
        return ($bday[2] . '-' . $bday[1] . '-' . $bday[0]);
    }

    private static function getPhoneFormat($phone)
    {        
        return substr($phone, 4, 13);     
    }

    /**
     * Update partial fields the specified customer
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function patch(Request $request, int $id)
    {
        $fields = [];

        $customer  = Customers::find($id);

        if (is_null($customer)) {
            throw new \Exception('Customer not found.');
        }

        foreach ($request->all() as $key => $value) {
            $fields[$key] = $value;
        }

        $customer->update($fields);
        return response()->json($customer, 200);
    }

    /**
     * Delete the specified customer
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(int $id)
    {
        $customer  = Customers::find($id);

        if (is_null($customer)) {
            throw new \Exception('Customer not found.');
        }
        $customer->delete();

        return response()->json('', 204, ['entity' => $id]);
    }

    private static function checkCustomerDeleted($email) {

        $customer = DB::table('customers')->where('email', $email)->whereNotNull('deleted_at')->get();

        if (count($customer) > 0) {
            return true;
        }

        return false;
    }
}

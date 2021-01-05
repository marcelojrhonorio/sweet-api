<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\DispatchCalogaLeadsStepFix::class,
        Commands\DispatchCalogaLeadsStep1Job::class,
        Commands\AllInMarketingDispatch::class,
        Commands\AllInMarketingEmailDispatch::class,
        Commands\AmbevSendEmailsDispatch::class,
        Commands\DispatchWeeklyMonthlySsi::class,
        Commands\UpdateCustomerByCep::class,
        Commands\UpdateCustomerPoints::class,
        Commands\ImportAddressFromExchange::class,
        Commands\DailyEmailConfirmationRecovery::class,
        Commands\DispatchPushMessage::class,
        Commands\DispatchInviteApp::class,
        Commands\AllInTestToken::class,
        //Commands\VerifyUsersAppMobile::class,
        Commands\UpdateCustomerPointsRaptorResearch::class,
        Commands\UpdateCustomerPointsAppMobile::class,
        Commands\VerifyAppIndication::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('caloga:dispatch')->dailyAt('12:00');
        $schedule->command('ssi:weekly-monthly-invites')->dailyAt('15:00');
        $schedule->command('customers:update-by-cep')->everyThirtyMinutes();
        $schedule->command('customers:zero-points')->dailyAt('12:30');
        $schedule->command('customers:confirmation-recovery')->hourly();
        $schedule->command('allin:test-token')->everyMinute();
        //$schedule->command('verify:users-app-mobile')->dailyAt('14:00');
        $schedule->command('customers:update-points-app-mobile')->dailyAt('14:00');
        $schedule->command('verify:app-mobile-indication')->dailyAt('18:00');
    }
}

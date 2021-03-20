<?php

namespace App\Console;

use App\Model\DayAddTotal;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->call(function () {
            // DayAddTotal::create([
            //     'info_employee_id' => 0,
            //     'id_create' => 0,
            //     'create_by' => 'Pham Ngoc Thang',
            //     'date_add' => Carbon::now(),
            //     'total_day' => 0,
            //     'total_add_group' => 0
            // ]);
            
        // })->everyMinute();
        $schedule->command('totalday:create')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

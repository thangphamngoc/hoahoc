<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TotalDayCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'totalday:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new total day';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::table('day_add_total')->insert([
            'info_employee_id' => 0,
            'id_create' => 0,
            'create_by' => 'Pham Ngoc Thang',
            'date_add' => Carbon::now(),
            'total_day' => 0,
            'total_add_group' => 0
        ]);
    }
}

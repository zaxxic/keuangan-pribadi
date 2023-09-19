<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateRecurringTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-recurring-transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ini untuk perlu';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info(app('App\Http\Controllers\ScheduleController')->createRecurringTransactions());
    }
}

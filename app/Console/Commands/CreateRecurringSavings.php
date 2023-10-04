<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateRecurringSavings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-recurring-savings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info(app('App\Http\Controllers\ScheduleController')->createRecurringSavings());
    }
}

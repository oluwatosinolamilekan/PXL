<?php

namespace App\Console\Commands;

use App\Actions\StoreProcess;
use Illuminate\Console\Command;

class StoreProcessCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store json data into the database';

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
     * @return int
     * @throws \Throwable
     */
    public function handle()
    {
         $this->output->progressStart(5);
         for ($i = 0; $i < 5; $i++) {
             sleep(1);
             $this->output->progressAdvance();
         }
         $this->output->progressFinish();
        $process = (new StoreProcess('challenge.json'))->run();
        return 0;
    }
}

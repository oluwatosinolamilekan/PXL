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
        try {

            $this->output->progressStart(2);
            for ($i = 0; $i < 2; $i++) {
                sleep(1);
                $this->output->progressAdvance();
            }
            $this->output->progressFinish();
            $time = (new StoreProcess('challenge.json'))->run();
            $this->info('The operation was successful!');
            return 0;
        }catch (\Exception $exception){
            $this->error($exception->getMessage());
            return 1;
        }
    }
}

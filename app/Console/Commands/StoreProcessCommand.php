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
     */
    public function handle()
    {
        $process = (new StoreProcess('challenge.json'))->run();
        return 0;
    }
}

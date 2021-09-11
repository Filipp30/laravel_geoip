<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class CleanAllLogFiles extends Command
{

    protected $signature = 'cleanLogFiles';


    protected $description = 'Command description';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $process = new Process(['sudo /home/exdir/run.sh']);
        $process->run();

    }
}

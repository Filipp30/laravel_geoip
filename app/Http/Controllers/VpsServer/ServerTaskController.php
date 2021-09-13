<?php

namespace App\Http\Controllers\VpsServer;

use App\Http\Controllers\Controller;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ServerTaskController extends Controller
{
    public function rm_log_files(){
        $process = new Process(['/home/exdir/run.sh']);
        $process->run();
        $process_status = $process->getOutput();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        return response([
            "shell-command"=>"cleanLogFiles",
            "status"=>$process_status,
        ],201);
    }
}

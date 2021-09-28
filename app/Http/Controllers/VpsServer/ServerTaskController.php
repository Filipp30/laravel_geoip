<?php

namespace App\Http\Controllers\VpsServer;

use App\Http\Controllers\Controller;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ServerTaskController extends Controller
{
    public function rm_log(){
        $process = new Process(['/home/exedir/run.sh']);
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

    public function ping_ip($ip){
        $ping_result = exec('ping -c1 '.$ip,$outcome,$status);
        return response([
            'ping_result'=>$ping_result,
            'outcome'=>$outcome,
            'status'=>$status
        ],201);
    }
}

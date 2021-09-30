<?php

namespace App\Http\Controllers\VpsServer;

use App\Http\Controllers\Controller;
use App\Repository\CreateDatabase\SqlManager;
use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ServerTaskController extends Controller
{
    public function rm_log(){
        $process = new Process(['/home/exedir/rm_log_files.sh']);
        $process->run();
        $process_status = $process->getOutput();

        if (!$process->isSuccessful()) {
            return response([
                'error'=>$process->getErrorOutput()
            ],201);
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

    public function create_database(Request $request, SqlManager $sqlManager){
        $db_name = $request['db_name'];
        $user_name = $request['user_name'];

        return response([
            "shell_command"=>"check if db && user exists",
            "db_exists"=>$sqlManager->databaseExists($db_name),
            "user_exists"=>$sqlManager->userExists($user_name)
        ],201);
    }


}

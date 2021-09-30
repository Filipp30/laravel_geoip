<?php


namespace App\Repository\CreateDatabase;


use Symfony\Component\Process\Process;

class SqlManager implements DatabaseRepositoryInterface {

    public function databaseExists($database_name)
    {
        $process = new Process(['/home/exedir/mysql_tasks/db_exists.sh',$database_name]);
        $process->run();
        $commandLine = $process->getCommandLine();
        $isSuccessful = $process->isSuccessful();
        $error = $process->getErrorOutput();

        return $process->getOutput();
    }

    public function userExists($user_name)
    {
        $process = new Process(['/home/exedir/mysql_tasks/user_exists.sh',$user_name]);
        $process->run();
        $commandLine = $process->getCommandLine();
        $isSuccessful = $process->isSuccessful();
        $error = $process->getErrorOutput();

        return $process->getOutput();
    }

    public function create()
    {
        // TODO: Implement create() method.
    }
}

<?php


namespace App\Repository\Services\CreateDatabase;


interface DatabaseRepositoryInterface{

    public function databaseExists($database_name):bool;

    public function userExists($user_name):bool;

    public function create($db_name,$user_name,$password);

}

<?php


namespace App\Repository\CreateDatabase;


interface DatabaseRepositoryInterface{

    public function databaseExists($database_name);

    public function userExists($user_name);

    public function create();

}

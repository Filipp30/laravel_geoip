<?php


namespace App\Repository\CreateDatabase;


interface DatabaseRepositoryInterface{

    public function databaseExists($database_name):bool;

    public function userExists($user_name):bool;

    public function create();

}

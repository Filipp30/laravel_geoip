<?php


namespace App\Services\Contracts;


interface IpRelationBindingContract{

    public function __construct($ip, $user_id);

    public function handleRelation();
}

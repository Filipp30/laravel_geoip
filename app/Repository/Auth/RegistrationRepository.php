<?php


namespace App\Repository\Auth;


use phpDocumentor\Reflection\Types\Integer;

interface RegistrationRepository{

    public function createUser($name,$email,$phone_number,$password);

    public function createIpRelation($ip,$id);

}

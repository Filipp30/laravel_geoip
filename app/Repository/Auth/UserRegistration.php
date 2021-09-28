<?php


namespace App\Repository\Auth;


use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRegistration implements RegistrationRepository {

    public function createUser($name, $email, $phone_number, $password){
        return User::create([
            'name' => $name,
            'email' => $email,
            'phone_number' => $phone_number,
            'password' => Hash::make($password),
        ]);
    }

    public function createIpRelation($ip, $id){
        // TODO: Implement createIpRelation() method.
    }

}

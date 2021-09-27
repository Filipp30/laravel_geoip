<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class RegistrationController extends Controller{

    public function registration(Request $request){

        $x_real_ip = $_SERVER['x_real_ip'];

        $validated_data = $request->validate([
            'name' => ['required', 'string', 'max:25'],
            'email' => ['required', 'string', 'email', 'max:35', 'unique:users'],
            'phone_number'=>['required','numeric','min:10','unique:users'],
            'password' => ['required', 'string','confirmed','min:6'],
        ]);

        $user = User::create([
            'name' => $validated_data['name'],
            'email' => $validated_data['email'],
            'phone_number' =>$validated_data['phone_number'],
            'password' => Hash::make($validated_data['password']),
        ]);

        event(new Registered($user));

        return response([
            'message'=>'Registration successfully.',
            'email'=>'Must verify your email before you can login !',
            'user_name'=>$user->name,
            'user-email'=>$user->email
        ],201);
    }

}

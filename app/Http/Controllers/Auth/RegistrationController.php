<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller{

    public function registration(Request $request){
        $remote_addr = $_SERVER['REMOTE_ADDR'];
        $validated_data = $request->validate([
            'ip'=> ['required','ip'],
            'name' => ['required', 'string', 'max:25'],
            'email' => ['required', 'string', 'email', 'max:35', 'unique:users'],
            'phone_number'=>['required','numeric','min:10','unique:users'],
            'password' => ['required', 'string','confirmed','min:6'],
        ]);

        $user = User::query()->create([
            'name' => $validated_data['name'],
            'email' => $validated_data['email'],
            'phone_number' =>$validated_data['phone_number'],
            'password' => Hash::make($validated_data['password']),
        ]);

        return response([
            'message'=>'email validation required.',
            'user'=>$user
        ],201);
    }

}

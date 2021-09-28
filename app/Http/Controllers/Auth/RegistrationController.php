<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\IpRelationJob;
use App\Repository\Auth\UserRegistration;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegistrationController extends Controller{

    public function registration(Request $request,UserRegistration $userRegistration){

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:25'],
            'email' => ['required', 'string', 'email', 'max:35', 'unique:users'],
            'phone_number'=>['required','numeric','min:10','unique:users'],
            'password' => ['required', 'string','confirmed','min:6'],
        ]);

        $user = $userRegistration->createUser($validated['name'],
        $validated['email'],$validated['phone_number'],$validated['password']);

        event(new Registered($user));

        if (array_key_exists('X-Real-Ip', getallheaders())){
            IpRelationJob::dispatch($user->id,getallheaders()['X-Real-Ip']);
        }

        return response([
            'message'=>'Registration successfully.',
            'email'=>'Must verify your email before you can login !',
            'user_name'=>$user->name,
            'user-email'=>$user->email
        ],201);
    }

}

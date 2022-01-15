<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Jobs\IpRelationJob;
use App\Repository\Models\UserRegistrationModel;
use App\Repository\Services\Auth\UserRepository;
use Illuminate\Auth\Events\Registered;

class RegistrationController extends Controller{

    public function registration(RegistrationRequest $request){

        $validated = $request->validated();

        if ($validated){
            $user = new UserRegistrationModel($validated['name'],$validated['email'],$validated['phone_number'],$validated['password']);
            $user = UserRepository::createUser($user);
            event(new Registered($user));
        }

        // Relate ip address to user.
        if (array_key_exists('X-Real-Ip', getallheaders())){
            IpRelationJob::dispatch($user->id,getallheaders()['X-Real-Ip']);
        }

        return response([
            'message'=>'Registration successfully.',
            'email'=>'Must verify your email before you can login !',
            'user_name'=>$user->name,
            'user_email'=>$user->email
        ],200);
    }
}

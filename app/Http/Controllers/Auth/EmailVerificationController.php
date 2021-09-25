<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller{

    public function emailVerify(Request $request){
        $user = User::findOrFail($request->id);
        $email_is_verified = $user->markEmailAsVerified();
        return response([
            'message'=>'Email is verified successfully.',
            'verified'=>$email_is_verified
        ],201);
    }

    public function sendEmailVerificationNotification(Request $request){
        $user = User::findOrFail($request->id);
        $user->sendEmailVerificationNotification();
        return response([
            'message'=>'Verification email send.',
        ],201);
    }
}

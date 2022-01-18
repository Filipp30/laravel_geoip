<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmailVerificationController extends Controller
{
    public function emailVerify(Request $request): Response|Application|ResponseFactory
    {
        $user = User::findOrFail($request->id);
        $email_is_verified = $user->markEmailAsVerified();
        return response([
            'message' => 'Email is verified successfully.',
            'verified' => $email_is_verified,
        ], 200);
    }

    public function sendEmailVerificationNotification(Request $request): Response|Application|ResponseFactory
    {
        $user = User::findOrFail($request->id);
        $user->sendEmailVerificationNotification();
        return response([
            'message' => 'Verification email send.',
        ], 200);
    }
}

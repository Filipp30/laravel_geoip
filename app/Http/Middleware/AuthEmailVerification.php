<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class AuthEmailVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next){
        $user = User::findOrFail($request->id);

        $hash_is_valid = hash_equals($request->hash,sha1($user->getEmailForVerification()));
        if (!$hash_is_valid){
            return response('Error: Hash is not equals sha1(Email for Verification).');
        }

        $hash_verified_email = $user->hasVerifiedEmail();
        if ($hash_verified_email){
            return response('Error: twice verify not possible!');
        }

        return $next($request);
    }
}

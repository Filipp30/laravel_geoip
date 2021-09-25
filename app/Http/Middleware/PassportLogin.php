<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class PassportLogin{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next){

        $validated = Validator::make($request->all(), [
            'ip'=> ['required','ip'],
            'email' => ['required','email','max:35',],
            'password' => ['required','string','min:6'],
        ]);
        if($validated->fails()){
            return response([
                'message'=>'Validation fails.',
                'error'=> $validated->errors()
            ],401);
        }

        $user = User::where('email','=',$request['email'])->first();
        if (!$user){
            return response([
                'message'=>'User not exist'
            ],401);
        }
        if (!Hash::check($request['password'],$user->password)){
            return response([
                'message'=>'The provided credentials are incorrect.'
            ],401);
        }
        return $next($request);
    }
}

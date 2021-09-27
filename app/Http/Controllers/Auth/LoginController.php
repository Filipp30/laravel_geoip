<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Services\IpToUserDataBindService\RelationHandler;
use Illuminate\Http\Request;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;

class LoginController extends Controller{

    public function login(Request $request,PasswordGrantClient $passwordGrantClient){

//        $x_real_ip = $_SERVER['x_real_ip'];
//        logs()->info('X-REAL-IP = '.$x_real_ip);

        $tokens = $passwordGrantClient->getAccessTokenAndRefreshToken($request['email'],$request['password']);

        if (!$tokens){
            return response([
                'response'=>'OAuthClient is invalid.'
            ],401);
        }
        return response([
            'tokens'=>$tokens
        ],201);
    }

    public function refresh(Request $request,PasswordGrantClient $passwordGrantClient){

        $new_tokens = $passwordGrantClient->refreshTokens($request['refresh_token']);

        if (!$new_tokens){
            return response([
                'response'=>'The refresh token is invalid.'
            ],401);
        }
        return response([
            'response'=>$new_tokens
        ],201);
    }

    public function logout(Request $request){
        $access_token_id = $request->user()->token()->id;
        $tokenRepository = app(TokenRepository::class);
        $refreshTokenRepository = app(RefreshTokenRepository::class);

        $revoke_status = $tokenRepository->revokeAccessToken($access_token_id);
        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($access_token_id);

        if (!$revoke_status){
            return response([
                'revoke_status'=>'Error:revoke status: FALSE'
            ],401);
        }
        return response([
            'revoke_status'=>$revoke_status,
            'message'=>'logout successfully.'
        ],201);
    }

}

<?php

namespace App\Repository\Services\Auth;

use Illuminate\Http\Request;
use Laravel\Passport\Client as OClient;
use function app;

class PasswordGrantClient
{

    private $oClient;

    public function __construct()
    {
        $this->oClient = OClient::query()->where('password_client', 1)->first();
    }

    public function getAccessTokenAndRefreshToken($user_email, $user_password)
    {
        $req = Request::create('/oauth/token', 'POST', [
            'grant_type' => 'password',
            'client_id' => $this->oClient->id,
            'client_secret' => $this->oClient->secret,
            'username' => $user_email,
            'password' => $user_password,
            'scope' => '',
        ]);

        $response = app()->handle($req);
        if ($response->getStatusCode() == 401) {
            return false;
        }

        return json_decode($response->getContent());
    }

    public function refreshTokens($refresh_token)
    {
        $req = Request::create('/oauth/token', 'POST', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refresh_token,
            'client_id' => $this->oClient->id,
            'client_secret' => $this->oClient->secret,
            'scope' => '',
        ]);

        $response = app()->handle($req);
        if ($response->getStatusCode() == 401) {
            return false;
        }

        return json_decode($response->getContent());
    }
}

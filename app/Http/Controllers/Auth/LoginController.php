<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Jobs\IpRelationJob;
use App\Models\User;
use App\Repository\Services\Auth\PasswordGrantClient;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;

class LoginController extends Controller
{
    public function login(LoginRequest $request, PasswordGrantClient $passwordGrantClient): Response|Application|ResponseFactory
    {
        $user_id = User::query()->where('email', '=', $request['email'])->first()->id;

        if (array_key_exists('X-Real-Ip', getallheaders()) && isset($user_id)) {
            IpRelationJob::dispatch($user_id, getallheaders()['X-Real-Ip']);
        }

        $tokens = $passwordGrantClient->getAccessTokenAndRefreshToken($request['email'], $request['password']);
        if (!$tokens) {
            return response([
                'response' => 'OAuthClient is invalid.',
            ], 400);
        }

        return response([
            'tokens' => $tokens,
        ], 200);
    }

    public function refresh(Request $request, PasswordGrantClient $passwordGrantClient): Response|Application|ResponseFactory
    {
        $new_tokens = $passwordGrantClient->refreshTokens($request['refresh_token']);
        if (!$new_tokens) {
            return response([
                'response' => 'The refresh token is invalid.',
            ], 400);
        }

        return response([
            'tokens' => $new_tokens,
        ], 200);
    }

    public function logout(Request $request): Response|Application|ResponseFactory
    {
        $access_token_id = $request->user()->token()->id;
        $tokenRepository = app(TokenRepository::class);
        $refreshTokenRepository = app(RefreshTokenRepository::class);
        $revoke_status = $tokenRepository->revokeAccessToken($access_token_id);
        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($access_token_id);
        if (!$revoke_status) {
            return response([
                'revoke_status' => 'Error:revoke status: FALSE',
            ], 400);
        }

        return response([
            'revoke_status' => $revoke_status,
            'message' => 'logout successfully.',
        ], 200);
    }
}

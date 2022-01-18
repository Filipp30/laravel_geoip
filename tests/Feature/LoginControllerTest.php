<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\CreatesApplication;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
        $this->user = User::factory()->create();
    }

    public function test_login()
    {
        $response = $this->post('/api/login', [
            'email' => $this->user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200);
    }

    public function test_login_access_token_is_valid()
    {
        $responseLogin = $this->post('/api/login', [
            'email' => $this->user->email,
            'password' => 'password'
        ]);
        $responseLogin->assertStatus(200);

        $response = $this->withToken($responseLogin['tokens']['access_token'])->get('/api/user');
        $response->assertStatus(200);

        $this->assertTrue($response['id'] == $this->user->id);
    }

    public function test_login_refresh_token_is_valid()
    {
        $responseLogin = $this->post('/api/login', [
            'email' => $this->user->email,
            'password' => 'password'
        ]);
        $responseLogin->assertStatus(200);

        $responseNewTokens = $this->post('/api/refresh', [
            'refresh_token' => $responseLogin['tokens']['refresh_token']
        ]);
        $responseNewTokens->assertStatus(200);

        $response = $this->withToken($responseNewTokens['tokens']['access_token'])->get('/api/user');
        $response->assertStatus(200);

        $this->assertTrue($response['id'] == $this->user->id);
    }

    public function test_logout()
    {
        //TODO: implementing passport logout test
    }
}

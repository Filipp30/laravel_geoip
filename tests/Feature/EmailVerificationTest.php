<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\CreatesApplication;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->unverified()->create();
    }

    public function test_email_verification_notification()
    {

        $response = $this->get('/api/email/verification-notification/' . $this->user->id);
        $response->assertStatus(200);
    }

    public function test_email_verify()
    {
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $this->user->id, 'hash' => sha1($this->user->email)]
        );
        $response = $this->actingAs($this->user)->get($verificationUrl);
        $response->assertStatus(200);
        $this->assertTrue($this->user->fresh()->hasVerifiedEmail());
    }

    public function test_email_is_not_verified_with_invalid_hash()
    {
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $this->user->id, 'hash' => sha1('wrong-email')]
        );
        $this->actingAs($this->user)->get($verificationUrl);
        $this->assertFalse($this->user->fresh()->hasVerifiedEmail());
    }
}

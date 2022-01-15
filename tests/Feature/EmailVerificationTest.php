<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_verification_notification(){
        $user = User::factory()->unverified()->create();
        $response = $this->get('/api/email/verification-notification/'.$user->id);
        $response->assertStatus(200);
    }

    public function test_email_verify(){
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );
        $response = $this->actingAs($user)->get($verificationUrl);
        $response->assertStatus(200);
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }

    public function test_email_is_not_verified_with_invalid_hash(){
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1('wrong-email')]
        );
        $this->actingAs($user)->get($verificationUrl);
        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }


}

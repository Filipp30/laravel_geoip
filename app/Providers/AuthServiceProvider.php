<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(){


        $this->registerPolicies();

        if (! $this->app->routesAreCached()) {
            Passport::routes();

            Passport::tokensExpireIn(now()->addHour());
            Passport::refreshTokensExpireIn(now()->addHours(3));
            Passport::personalAccessTokensExpireIn(now()->addHours(5));
        }

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
            ->subject('Verify Email Address')
            ->line('This app is in development mode. Developer:Filipp Grigoruk.')
            ->line('Click the button below to verify your email address.')
            ->action('Verify Email Address', $url);
        });
    }
}

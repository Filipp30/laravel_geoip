<?php

namespace App\Providers\ExternalServices;

use App\Services\Contracts\IpRelationBindingContract;
use App\Services\IpToUserDataBindService\RelationHandler;
use Illuminate\Support\ServiceProvider;

class IpRelationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IpRelationBindingContract::class,RelationHandler::class);
    }

}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class InterfaceServiceBindProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(\App\Modules\Products\Interfaces\ProductServiceInterface::class, \App\Modules\Products\Services\ProductService::class);
    }
}

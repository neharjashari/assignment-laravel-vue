<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class InterfaceRepositoryBindProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(\App\Modules\Products\Interfaces\ProductRepositoryInterface::class, \App\Modules\Products\Repositories\ProductRepository::class);
    }
}

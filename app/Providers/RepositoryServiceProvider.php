<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\Abstracts\PaymentRepository::class, \App\Repositories\PaymentRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Abstracts\InvoiceRepository::class, \App\Repositories\InvoiceRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Abstracts\SchoolRepository::class, \App\Repositories\SchoolRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Abstracts\UserRepository::class, \App\Repositories\UserRepositoryEloquent::class);
        //:end-bindings:
    }
}

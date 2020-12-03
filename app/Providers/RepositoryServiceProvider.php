<?php

namespace App\Providers;

use App\Services\Contracts\PaymentService as PaymentServiceInterface;
use App\Services\Contracts\InvoiceService as InvoiceServiceInterface;
use App\Services\Contracts\UserService as UserServiceInterface;
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


        $this->app->bind(PaymentServiceInterface::class, \App\Services\PaymentService::class);
        $this->app->bind(InvoiceServiceInterface::class, \App\Services\InvoiceService::class);
        $this->app->bind(UserServiceInterface::class, \App\Services\UserService::class);
        //:end-bindings:
    }
}

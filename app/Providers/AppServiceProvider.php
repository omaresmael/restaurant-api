<?php

namespace App\Providers;

use App\Services\Invoicable;
use App\Services\InvoiceService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(Invoicable::class, InvoiceService::class);
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}

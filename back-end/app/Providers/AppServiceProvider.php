<?php

namespace App\Providers;

use App\Models\Money;
use App\Models\MoneyInterface;
use App\Models\Product;
use App\Models\ProductInterface;
use App\Services\CartInterface;
use App\Services\CartService;
use App\Services\StockInterface;
use App\Services\StockService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(MoneyInterface::class, Money::class);
        $this->app->bind(ProductInterface::class, Product::class);
        $this->app->bind(CartInterface::class, CartService::class);
        $this->app->bind(StockInterface::class, StockService::class);
    }

    public function boot(): void
    {
        //
    }
}

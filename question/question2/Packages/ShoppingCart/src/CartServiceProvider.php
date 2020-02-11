<?php
namespace Hiskio\Shoppingcart;

use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views/', 'cart');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    public function register()
    {
        
    }
}
<?php

namespace App\Providers;
use App\Interfaces\TransactionInterface;
use App\Interfaces\UserInterface;
use App\Interfaces\WalletInterface;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(WalletInterface::class, WalletRepository::class);
        $this->app->bind(TransactionInterface::class, TransactionRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

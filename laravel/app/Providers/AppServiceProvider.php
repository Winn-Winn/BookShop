<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $baseUrlDaoInterface = 'App\Contracts\Dao';
        $baseUrlDao = 'App\Dao';
        $baseUrlServiceInterface = 'App\Contracts\Services';
        $baseUrlService = 'App\Services';

        // Dao Registration
        $this->app->bind($baseUrlDaoInterface . '\UserDaoInterface', $baseUrlDao . '\UserDao');
        $this->app->bind($baseUrlDaoInterface . '\BookDaoInterface', $baseUrlDao . '\BookDao');
        $this->app->bind($baseUrlDaoInterface . '\CommentReactDaoInterface', $baseUrlDao . '\CommentReactDao');
        $this->app->bind($baseUrlDaoInterface . '\CartDaoInterface', $baseUrlDao . '\CartDao');
        $this->app->bind($baseUrlDaoInterface . '\OrderDaoInterface', $baseUrlDao . '\OrderDao');

        // Service Registration
        $this->app->bind($baseUrlServiceInterface . '\UserServiceInterface', $baseUrlService . '\UserService');
        $this->app->bind($baseUrlServiceInterface . '\BookServiceInterface', $baseUrlService . '\BookService');
        $this->app->bind($baseUrlServiceInterface . '\CommentReactServiceInterface', $baseUrlService . '\CommentReactService');
        $this->app->bind($baseUrlServiceInterface . '\CartServiceInterface', $baseUrlService . '\CartService');
        $this->app->bind($baseUrlServiceInterface . '\OrderServiceInterface', $baseUrlService . '\OrderService');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

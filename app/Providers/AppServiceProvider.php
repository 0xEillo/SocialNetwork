<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Post;
use App\Models\Comment;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Option 1: Every single view
        View::share('posts', Post::all());
        View::share('comments', Comment::all());

        //Option2: Attach data to a single view using composer
        //View::composer(['dashboard', 'vendor', 'livewire.my-dashboard'], function($view) {
            //$view->with('posts', Post::all());
        //});


    }
}

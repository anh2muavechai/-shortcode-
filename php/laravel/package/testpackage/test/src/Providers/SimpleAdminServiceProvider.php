<?php

// namespace App\Http\Controllers;
namespace testpackage\test\Providers;

use Illuminate\Support\ServiceProvider;

class SimpleAdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // load routes
      $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
      // include __DIR__.'/../routes/web.php';

      // load view files
      $this->loadViewsFrom(__DIR__.'/../Views', 'testpackage');

      // publish files
      $this->publishes([
      __DIR__.'/../views' => resource_path('views/vendor/testpackage'),
    ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    	// $this->middleware('auth');
        //
        // include __DIR__.'/routes.php';
        // $this->app->make('testpackage\test\SimpleAdminServiceProvider');
    }


}

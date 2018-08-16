<?php

// namespace App\Http\Controllers;
namespace testpackage\test;


use Illuminate\Support\ServiceProvider;

use Illuminate\Http\Request;

use App\Http\Requests;

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

      /*// load view files
      $this->loadViewsFrom(__DIR__.'/../views', 'aws');

      // publish files
      $this->publishes([
      __DIR__.'/../views' => resource_path('views/vendor/aws'),
    ]);*/
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

    public function __construct() {

      }

      /**
      * Display a listing of the resource.
      *
      * @return Response
      */
      public function index()
      {
        // return view('simpleAdmin::admin');
        $laravel = app();
		$version = $laravel::VERSION;
		echo 'Laravel: '.$version;
    	return view('general');
      }
}

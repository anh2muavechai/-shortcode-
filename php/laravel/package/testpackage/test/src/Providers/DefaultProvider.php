<?php
//nho run lenh composer dump autoload
namespace Envato\Aws\Providers;

use Illuminate\Support\ServiceProvider;

class DefaultProvider extends ServiceProvider
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

      // load view files
      $this->loadViewsFrom(__DIR__.'/../views', 'aws');

      // publish files
      $this->publishes([
      __DIR__.'/../views' => resource_path('views/vendor/aws'),
    ]);
  }

  /**
   * Register the application services.
   *
   * @return void
   */
  public function register()
  {
  }
}
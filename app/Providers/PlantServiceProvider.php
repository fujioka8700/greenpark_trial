<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PlantServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    $this->app->bind('plant', 'App\Models\Plant');
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    //
  }
}

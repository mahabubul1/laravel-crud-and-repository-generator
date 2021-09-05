<?php
namespace Mahabub\CrudGenerator;

use Illuminate\Support\ServiceProvider;
use Mahabub\CrudGenerator\Commands\CrudGenerator;

class CrudServiceProvider extends ServiceProvider{
    
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        $this->loadViewsFrom(__DIR__.'/resources/stubs', 'CrudGenerator');
        $this->publishes([__DIR__.'/resources/stubs' => resource_path('mahabub/stubs')] ,'resources');
        $this->commands([CrudGenerator::class]);
        
    }
      /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {}

  
}
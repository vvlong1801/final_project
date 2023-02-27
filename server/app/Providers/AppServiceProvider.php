<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services;

class AppServiceProvider extends ServiceProvider
{
    protected $bindingServices = [
        Services\Interfaces\ExerciseServiceInterface::class => Services\ExerciseService::class,
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerServices();
    }

    public function registerServices()
    {
        foreach ($this->bindingServices as $interface => $service) {
            app()->bind($interface, $service);
        }
    }
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

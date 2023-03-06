<?php

namespace App\Providers;

use App\Enums\MediaDisk;
use Illuminate\Support\ServiceProvider;
use App\Services;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class AppServiceProvider extends ServiceProvider
{
    protected $bindingServices = [
        Services\Interfaces\ExerciseServiceInterface::class => Services\ExerciseService::class,
        Services\Interfaces\EquipmentServiceInterface::class => Services\EquipmentService::class,
        Services\Interfaces\MuscleServiceInterface::class => Services\MuscleService::class,
        Services\Interfaces\MediaServiceInterface::class => Services\LocalService::class,
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // $this->registerContextualServices();
        $this->registerServices();
    }

    public function registerServices()
    {
        foreach ($this->bindingServices as $interface => $service) {
            app()->bind($interface, $service);
        }
    }

    public function registerContextualServices()
    {
        // app()->when(Services\LocalService::class)->needs(Filesystem::class)->give(function () {
        //     return Storage::disk(MediaDisk::public->name);
        // });
        // app()->when(Services\S3Service::class)->needs(Filesystem::class)->give(function () {
        //     return Storage::disk(MediaDisk::s3->name);
        // });
    }
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

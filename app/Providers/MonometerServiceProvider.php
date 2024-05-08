<?php declare(strict_types=1);

namespace LaravelMonometer\Providers;

use Illuminate\Support\ServiceProvider;
use LaravelMonometer\Services\MonometerService;

class MonometerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/monometer.php' => config_path('monometer.php'),
            ]);
        }
        $this->app->bind('monometer', MonometerService::class);
    }
}

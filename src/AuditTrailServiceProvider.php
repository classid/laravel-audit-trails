<?php

namespace CID\AuditTrails;

use Illuminate\Support\Fluent;
use Illuminate\Support\ServiceProvider;

class AuditTrailServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->registerMigrations();
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . "/../config/auditor.php",
            'auditor'
        );

        $this->app->singleton('auditor.repository',static fn($app) => new RepositoryManager($app));
        $this->app->alias('auditor.repository', RepositoryManager::class);


        $this->app->singleton('auditor', fn($app) => new Auditor($this->app['auditor.repository']));
    }

    protected function registerMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}

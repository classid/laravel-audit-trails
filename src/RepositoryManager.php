<?php

namespace CID\AuditTrails;

use CID\AuditTrails\Contracts\RepositoryContract;
use Illuminate\Foundation\Application;

class RepositoryManager
{
    protected array $drivers = [];

    protected array $customCreators = [];

    public function __construct(protected Application $app)
    {
    }

    public function drivers(): array
    {
        return [...array_keys($this->drivers), ...array_keys($this->customCreators)];
    }

    public function extend(string $driver, \Closure $callback): self
    {
        $this->customCreators[$driver] = $callback;

        return $this;
    }

    public function driver(string $name, bool $reload = false): RepositoryContract
    {
        if ($reload){
            return $this->resolve($name);
        }

        return $this->drivers[$name] ?? $this->drivers[$name] = $this->resolve($name);
    }

    public function resolve($name): RepositoryContract
    {
        $config = $this->app['config']->get('auditor.' . $name, []);


    }
}

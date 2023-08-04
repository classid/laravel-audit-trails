<?php

namespace CID\AuditTrails;

use CID\AuditTrails\Contracts\RepositoryContract;
use Illuminate\Foundation\Application;
use InvalidArgumentException;

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
        $config = $this->app['config']["auditor.repositories.{$name}"];

        if (empty($config)) {
            throw new InvalidArgumentException("Auditor repository [{$name}] is not configured");
        }

        if (isset($this->customCreators[$name]))
        {
            return $this->callCustomCreators($name, $config);
        }

        // define built-in repository
        $driverMethod = 'create'.ucfirst($name)."Driver";

        if (method_exists($this, $driverMethod))
        {
            return $this->{$driverMethod}($config);
        }

        throw new InvalidArgumentException("Auditor repository [{$name}] is not defined");
    }

    public function createDatabaseDriver(array $config): RepositoryContract
    {
        return new DatabaseRepository($config);
    }


    private function callCustomCreators($name, array $config): RepositoryContract
    {
        return $this->customCreators[$name]($this->app, $name, $config);
    }
}

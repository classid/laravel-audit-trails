<?php

namespace CID\AuditTrails;

use CID\AuditTrails\Contracts\AuditableContract;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * Auditor Builder and factory
 *
 * @property \CID\AuditTrails\RepositoryManager $repository
 * @property \CID\AuditTrails\State|null $state;
 */
class Auditor
{
    /**
     * Audit State
     *
     * @var \CID\AuditTrails\State|null
     */
    protected State|null $state = null;

    /**
     * Repository driver name
     *
     * @var string|null
     */
    protected string|null $driver = null;

    public function __construct(protected RepositoryManager $repository)
    {
    }

    public function make(): static
    {
        return (new static($this->repository))->state(new State());
    }

    public function state(State $state): self
    {
        $this->state = $state;
        return $this;
    }

    public function on(AuditableContract $auditable): self
    {
        $this->state->auditable = $auditable;

        return $this;
    }

    public function by(Authenticatable $performer): self
    {
        $this->state->performer = $performer;
        return $this;
    }

    public function type(string $type): self
    {
        $this->state->type = $type;

        return $this;
    }

    public function message(string $message): self
    {
        $this->state->message = $message;
        return $this;
    }

    public function changes(array $before, array $after): self
    {
        $this->state->before = $before;
        $this->state->after = $after;
        return $this;
    }
}

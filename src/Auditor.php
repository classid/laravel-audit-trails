<?php

namespace CID\AuditTrails;

use CID\AuditTrails\Contracts\AuditableContract;
use Illuminate\Contracts\Auth\Authenticatable;

class Auditor
{
    protected bool $isAuto = false;

    public function __construct(protected RepositoryManager $repository)
    {
    }

    public function auto(): self
    {
        $this->isAuto = true;
        return $this;
    }

    public function on(AuditableContract $auditable): self
    {
        $this->auditable = $auditable;

        return $this;
    }

    public function by(Authenticatable $performer): self
    {
        $this->performer = $performer;
        return $this;
    }

}

<?php

namespace CID\AuditTrails\Contracts;

use CID\AuditTrails\State;

interface RepositoryContract
{
    public function getConfig(): array;

    public function setConfig(array $config): self;

    public function save(State $state): void;

}

<?php

namespace CID\AuditTrails\Contracts;

interface AuditableContract
{
    public function getAuditableType(): string;

    public function getAuditableId(): int|string;
}

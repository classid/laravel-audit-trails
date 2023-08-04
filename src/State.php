<?php

namespace CID\AuditTrails;

use CID\AuditTrails\Contracts\AuditableContract;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Fluent;

/**
 * Audit State Object
 *
 * @property string|null $type
 * @property string|null $message
 * @property AuditableContract|null $auditable
 * @property Authenticatable|null $performer
 * @property array $before
 * @property array $after
 * @property string|null $via
 * @property string|null $user_agent
 * @property string|null $ip_address
 * @property string|null $current_url
 * @property boolean $is_auto
 */
class State extends Fluent
{
    public function __construct(
        protected string|null $type = null,
        protected string|null $message = null,
        protected AuditableContract|null $auditable = null,
        protected Authenticatable|null $performer = null,
        protected array $before = [],
        protected array $after = [],
    )
    {
        parent::__construct(compact('type', 'message', 'auditable', 'performer', 'before', 'after'));

        $this->resolveMetadata();
    }

    private function resolveMetadata(): void
    {
        $this->via = app()->runningInConsole() ? "console" : "web";
        $this->user_agent = request()->userAgent();
        $this->ip_address = request()->ip();
        $this->current_url = url()->current();
        $this->is_auto = false;
    }
}

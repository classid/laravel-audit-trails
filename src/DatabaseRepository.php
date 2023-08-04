<?php

namespace CID\AuditTrails;

use CID\AuditTrails\Contracts\RepositoryContract;

class DatabaseRepository implements RepositoryContract
{
    public function __construct(protected array $config)
    {
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function setConfig(array $config): self
    {
        $this->config = $config;


        return $this;
    }

    public function save(State $state): void
    {
        // do validation on $state.
        $attributes = [
            'state' => $state->type,
            'message' => $state->message,
            'before' => $state->before,
            'after' => $state->after,
            'via' => $state->via,
            'user_agent' => $state->user_agent,
            'ip_address' => $state->ip_address,
            'current_url' => $state->current_url,
        ];

        // extract auditable object
        $attributes['auditable_type'] = $state->auditable->getAuditableType();
        if (is_string($state->auditable->getAuditableId())) {
            $attributes['auditable_uuid'] = $state->auditable->getAuditableId();
        } else {
            $attributes['auditable_id'] = $state->auditable->getAuditableId();
        }

        // extract performer attributes
        if ($state->performer) {
            $attributes['performer_type'] = $state->performer_type;
            $attributes['performer_id'] = $state->performer_id;
        }

        $record = $this->model();
        $record->forceFill($attributes);

        $record->save();
    }

    protected function model(): AuditModel
    {
        $model = $this->config['model'];

        return new $model();
    }
}

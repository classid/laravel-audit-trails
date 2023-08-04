<?php

namespace CID\AuditTrails;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AuditModel extends Model
{
    use HasUuids;

    protected $table = 'audits';

    protected $casts = [
        'is_auto' => 'boolean',
        'before' => 'json',
        'after'  => 'json',
        'tags' => 'array'
    ];


    public function auditable(): MorphTo
    {
        return $this->morphTo(
            'auditable',
            'auditable_type',
            $this->auditable_id ? 'auditable_id': 'auditable_uuid');
    }

    public function performer(): MorphTo
    {
        return $this->morphTo('performer');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class DoorTemplate extends Model
{
    protected $table = 'door_templates';

    public function doorStyle(): BelongsTo
    {
        return $this->belongsTo(DoorStyle::class);
    }

    public function doorType(): BelongsTo
    {
        return $this->belongsTo(DoorType::class);
    }
}

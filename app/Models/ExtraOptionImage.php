<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class ExtraOptionImage extends Model
{
    protected $table = 'extra_option_image';

    public function glassThickness(): BelongsTo
    {
        return $this->belongsTo(GlassThickness::class);
    }

    public function glassType(): BelongsTo
    {
        return $this->belongsTo(GlassType::class);
    }

    public function hardwareFinish(): BelongsTo
    {
        return $this->belongsTo(HardwareFinish::class);
    }

    public function handle(): BelongsTo
    {
        return $this->belongsTo(Handle::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class GlassType extends Model
{
    protected $table = 'glass_type';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = Str::slug($model->name);
        });

        static::updating(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }

    public function glassThickness()
    {
        return $this->belongsToMany(GlassThickness::class);
    }

    public function extraOptionImage(): HasOne
    {
        return $this->hasOne(ExtraOptionImage::class);
    }
}

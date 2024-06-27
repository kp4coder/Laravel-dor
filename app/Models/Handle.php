<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Handle extends Model
{
    protected $table = 'handle';

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

    public function hardwareFinish()
    {
        return $this->belongsToMany(HardwareFinish::class);
    }

    public function extraOptionImage(): HasOne
    {
        return $this->hasOne(ExtraOptionImage::class);
    }
}

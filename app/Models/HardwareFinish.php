<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class HardwareFinish extends Model
{
    protected $table = 'hardware_finish';

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

    public function handle()
    {
        return $this->belongsToMany(Handle::class);
    }

    public function extraOptionImage(): HasOne
    {
        return $this->hasOne(ExtraOptionImage::class);
    }
}

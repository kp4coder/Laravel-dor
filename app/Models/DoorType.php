<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class DoorType extends Model
{
    protected $table = 'door_type';

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

    public function doorTemplate(): HasOne
    {
        return $this->hasOne(DoorTemplate::class);
    }
}

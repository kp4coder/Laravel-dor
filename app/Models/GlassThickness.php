<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class GlassThickness extends Model
{
    protected $table = 'glass_thickness';
    
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

    public function glassType()
    {
        return $this->belongsToMany(GlassType::class);
    }

    public function extraOptionImage(): HasOne
    {
        return $this->hasOne(ExtraOptionImage::class);
    }
   
}

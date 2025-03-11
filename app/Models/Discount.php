<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Discount extends Model
{

    protected $fillable = [
        'name', 'percentage', 'start_date', 'end_date', 'status', 'slug'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($discount) {
            $discount->slug = Str::slug($discount->name);
        });

        static::updating(function ($discount) {
            $discount->slug = Str::slug($discount->name);
        });
    }

    protected $casts = [
        'percentage' => 'float',
        'start_date' => 'datetime:d-m-Y',
        'end_date'   => 'datetime:d-m-Y',
        'status'     => 'string',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}

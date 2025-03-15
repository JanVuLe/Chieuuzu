<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable = ['name', 'location'];

    public function warehouseProducts()
    {
        return $this->hasMany(WarehouseProduct::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'warehouse_products')
            ->withPivot('quantity');
    }
}

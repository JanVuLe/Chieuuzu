<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'order_id',
        'method',
        'amount',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isFailed()
    {
        return $this->status === 'failed';
    }

    // Phương thức tiện ích: Lấy tên phương thức thanh toán
    public function getMethodNameAttribute()
    {
        $methods = [
            'bank_transfer' => 'Chuyển khoản ngân hàng',
            'cash_on_delivery' => 'Thanh toán khi nhận hàng (COD)',
        ];

        return $methods[$this->method] ?? $this->method;
    }
}

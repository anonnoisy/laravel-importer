<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'invoice_number',
        'weight_total',
        'shipping_cost',
        'total_price',
        'total_purchase_price',
        'customer_id',
        'shipping_address',
        'shipping_service_id',
        'shipping_type',
        'shipping_date',
        'transaction_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'shipping_date' => 'datetime',
        'transaction_date' => 'datetime',
    ];
}

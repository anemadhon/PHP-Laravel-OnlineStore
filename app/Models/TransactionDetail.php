<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'awb_number', 'shipping_status', 
        'purchase_price', 'purchase_quantity',
        'transaction_id', 'product_id', 'store_id',
        'unique_number'
    ];

    protected $casts = ['total_each_product'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    
    public function stores()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function getTotalEachProductAttribute()
    {
        return $this->purchase_price * $this->purchase_quantity;
    }
}

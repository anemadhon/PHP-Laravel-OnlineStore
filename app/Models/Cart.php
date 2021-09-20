<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'product_id',
        'purchase_quantity'
    ];

    protected $appends = ['total_each_product'];

    public function getTotalEachProductAttribute()
    {
        return $this->product->price * $this->purchase_quantity;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

<?php
// app/Models/StockMovement.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $fillable = ['product_id', 'user_id', 'type', 'quantity', 'notes'];

    // ទំនាក់ទន្តជាមួយ Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // ទំនាក់ទន្តជាមួយ User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'supplier_id',
        'name',
        'SKU',
        'Cost',
        'Price',
        'image',
        'description',
        'Note',
        'status',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
    public function stockTransactions() 
    {
        return $this->hasMany(StockTransaction::class);
    }
    public function suppliers()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id'); // ពិនិត្យមើល Foreign Key ក្នុងតาราง products របស់អ្នក ថាតើឈ្មោះ supplier_id ឬយ៉ាងណា
    }
}

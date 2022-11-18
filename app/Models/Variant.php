<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = ["sku", "product_id", "size_id", "color_id", "price", "quantity"];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

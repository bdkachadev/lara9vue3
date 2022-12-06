<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\VariantAttribute;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = ["sku", "product_id", "size_id", "color_id", "price", "quantity", "attribute_id"];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attributes()
    {
        return $this->hasMany(VariantAttribute::class);
    }

    public function image()
    {
        return $this->hasOne(VariantImage::class);
    }
}

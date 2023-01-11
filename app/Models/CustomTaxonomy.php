<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomTaxonomy extends Model
{
    use HasFactory;

    // public function products()
    // {
    //     // return $this->belongsTomMany(TaxonomyAttribute::class);
    //     return $this->belongsToMany(Product::class, "product_taxonomy", "taxonomy_id", "attribute_id");
    // }
 
    public function attributes()
    {
        // return $this->belongsTomMany(TaxonomyAttribute::class);
        return $this->hasMany(TaxonomyAttribute::class, "taxonomy_id", "id");
    }
}

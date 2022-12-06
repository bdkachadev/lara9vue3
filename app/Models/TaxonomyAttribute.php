<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxonomyAttribute extends Model
{
    use HasFactory;

    public function taxonomies()
    {
        // return $this->belongsToMany(CustomerTaxonomy::class);
        return $this->belongsToMany(CustomTaxonomy::class, "attribute_taxonomy",  "taxonomy_id", "attribute_id");
    }

    public function taxonomy()
    {
        // return $this->belongsToMany(CustomerTaxonomy::class);
        return $this->belongsTo(CustomTaxonomy::class);
    }

    public function products()
    {
        // return $this->belongsTomMany(TaxonomyAttribute::class);
        return $this->belongsToMany(Product::class, "product_taxonomies",  "attribute_id", "product_id");
    }
}

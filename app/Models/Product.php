<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Variant;
use App\Models\Brand;
use App\Models\Tag;


class Product extends Model
{
    use HasFactory;

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class);
    }

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // public function taxonomies()
    // {
    //     // return $this->belongsToMany(CustomTaxonomy::class);
    //     return $this->belongsToMany(CustomTaxonomy::class, "product_taxonomy",  "taxonomy_id", "product_id");
    // }

    public function taxonomy_attributes()
    {
        // return $this->belongsToMany(CustomTaxonomy::class);
        return $this->belongsToMany(TaxonomyAttribute::class, "product_taxonomies",  "product_id", "attribute_id");
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'parent_id', "description"];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }


    public function sub_categories()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function parent_category()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }
}

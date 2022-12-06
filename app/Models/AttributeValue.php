<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attribute;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = [
        "attribute_id",
        "slug",
        "value"
    ];
    protected $table = "attribute_values";

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}

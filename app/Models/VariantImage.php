<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantImage extends Model
{
    use HasFactory;

    public function variant()
    {
        return $this->belongsTo(App\Models\Variant::class);
    }
}

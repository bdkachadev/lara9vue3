<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Variant;

class VariantAttribute extends Model
{
    use HasFactory;

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
}

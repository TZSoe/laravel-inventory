<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }
}

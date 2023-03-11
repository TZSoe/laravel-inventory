<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function payment()
    {
        return $this->belongsTo(\App\Models\Payment::class, 'id', 'invoice_id');
    }

    public function invoice_details()
    {
        return $this->hasMany(\App\Models\InvoiceDetails::class);
    }

    public function payment_details()
    {
        return $this->hasMany(\App\Models\PaymentDetails::class);
    }
}

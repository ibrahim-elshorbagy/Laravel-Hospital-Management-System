<?php

namespace App\Models\Invoice;

use App\Models\Doctor\Doctor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    // public function invoice()
    // {
    //     return $this->belongsTo(Invoice::class);
    // }

}

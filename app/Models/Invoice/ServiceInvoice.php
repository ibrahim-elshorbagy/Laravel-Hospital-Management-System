<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceInvoice extends Model
{
    use HasFactory;
    protected $guarded = [];
     public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

}

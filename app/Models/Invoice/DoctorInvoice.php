<?php

namespace App\Models\Invoice;

use App\Models\Clinic\Clinic;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorInvoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
}

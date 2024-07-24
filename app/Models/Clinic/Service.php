<?php

namespace App\Models\Clinic;

use App\Models\Invoice\Invoice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'package_service');
    }
    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'service_invoice');
    }
}


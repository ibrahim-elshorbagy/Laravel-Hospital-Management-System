<?php

namespace App\Models\Invoice;

use App\Models\Clinic\Clinic;
use App\Models\Clinic\Service;
use App\Models\Doctor\Doctor;
use App\Models\Patient\Patient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor\Diagnostic;
class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function clinic(){
        return $this->belongsTo(Clinic::class);
    }
    public function details()
    {
        return $this->hasOne(InvoiceDetail::class);
    }

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'doctor_invoices')
                    ->withPivot('id','clinic_id', 'daily_patient_index','status');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_invoices')
                    ->withPivot('id','daily_patient_index','status');
    }
      public function diagnostics()
    {
        return $this->hasMany(Diagnostic::class);
    }
}

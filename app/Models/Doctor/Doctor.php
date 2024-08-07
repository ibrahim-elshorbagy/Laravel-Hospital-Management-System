<?php

namespace App\Models\Doctor;

use App\Models\Clinic\Clinic;
use App\Models\Invoice\Invoice;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function appointments()
    {
        return $this->hasMany(DoctorAppointment::class);
    }

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'doctor_invoices')
                    ->withPivot('id','clinic_id', 'daily_patient_index','status');
    }

    public function diagnostics()
    {
        return $this->hasMany(Diagnostic::class);
    }
}

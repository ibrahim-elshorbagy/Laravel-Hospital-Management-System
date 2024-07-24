<?php

namespace App\Models\Clinic;

use App\Models\Doctor\Doctor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
}

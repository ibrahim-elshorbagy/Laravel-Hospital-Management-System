<?php

namespace App\Models\Patient;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor\Diagnostic;
class Patient extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
      public function diagnostics()
    {
        return $this->hasMany(Diagnostic::class);
    }
}

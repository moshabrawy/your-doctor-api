<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientDetail extends Model
{
    use HasFactory;
    protected $fillable = ['appointment_id', 'patient_name', 'age', 'disease_dec'];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}

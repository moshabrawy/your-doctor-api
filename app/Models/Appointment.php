<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = ['slot_id', 'user_id', 'doctor_id', 'day_date', 'status'];

    public function time_slot()
    {
        return $this->belongsTo(TimeSlot::class, 'slot_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }
    public function patient_details()
    {
        return $this->hasOne(PatientDetail::class,);
    }

}

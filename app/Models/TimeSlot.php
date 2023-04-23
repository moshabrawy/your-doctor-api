<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'address_id', 'day_en', 'day_ar', 'start_time', 'end_time'];

    public function setStartTimeAttribute($value)
    {
        return $this->attributes['start_time'] = Carbon::createFromFormat('h:i A', $value)->format('H:i:s');
    }
    public function setEndTimeAttribute($value)
    {
        return $this->attributes['end_time'] = Carbon::createFromFormat('h:i A', $value)->format('H:i:s');
    }
    public function doctor_info()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    public function appointment()
    {
        return $this->hasMany(Appointment::class);
    }
}

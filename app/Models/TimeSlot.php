<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'address_id', 'day_en', 'day_ar', 'start_time', 'end_time'];

    public function doctor_info()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

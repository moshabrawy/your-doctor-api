<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['user_id', 'address', 'state', 'country'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function time_slots()
    {
        return $this->hasMany(TimeSlot::class);
    }
}

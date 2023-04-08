<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specialty extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['title', 'icon', 'brief'];

    public function doctor_info()
    {
        return $this->belongsTo(DoctorInfo::class);
    }
}

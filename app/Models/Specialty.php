<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specialty extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['title', 'image', 'brief'];

    public function doctor_info()
    {
        return $this->belongsTo(DoctorInfo::class);
    }

    public function getImageAttribute($avatar)
    {
        if ($avatar != '') {
            return url('uploads/images/specialities/' . $avatar);
        } else {
            return url('assets/images/defualt-specialist-icon.jpg');
        }
    }
}

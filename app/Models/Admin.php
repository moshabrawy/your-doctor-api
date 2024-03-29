<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'email', 'password', 'avatar', 'gender', 'phone'];

    public function getAvatarAttribute($avatar)
    {
        if ($avatar != '') {
            return url('uploads/images/admin-avatars/' . $avatar);
        } else {
            return url('assets/images/user.png');
        }
    }
}

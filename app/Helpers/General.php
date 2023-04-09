<?php

function check_user_type()
{
    if (auth()->guard('api')->check() && auth()->guard('api')->user()->user_type == 0) {
        return 'doctor';
    } elseif (auth()->guard('api')->check() && auth()->guard('api')->user()->user_type == 1) {
        return 'user';
    } elseif (auth()->guard('admin')->check()) {
        return 'admin';
    }
}

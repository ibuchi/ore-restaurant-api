<?php

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

/**
 * @param null $key
 * @return Authenticatable|User|null
 */
function user($key = NULL): mixed
{
    $user = Auth::user();

    return $key ? $user?->{$key} : $user;
}

if (!function_exists('format_money')) {
    function format_money($amount)
    {
        return '₦' . number_format($amount, 2);
    }
}


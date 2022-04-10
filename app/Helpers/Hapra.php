<?php

use App\Models\Role;
use Illuminate\Support\Facades\Auth;

if (!function_exists('set_active')) {
    // function set_active($route)
    // {
    //     if (is_array($route)) {
    //         return in_array(Request::path(), $route) ? 'active' : '';
    //     }
    //     return Request::path() == $route ? 'active' : '';
    // }
    function set_active($route, $output = 'active')
    {
        if (is_array($route)) {
            foreach ($route as $uri) {
                // return in_array(Route::is(), $uri) ? 'active' : '';
                if (Route::is($uri)) return $output;
            }
        } else {
            // return Request::path($route) ? 'active' : '';
            if (Route::is($route)) return $output;
        }
    }
}

if (!function_exists('user_role')) {
    function user_role()
    {
        return Role::where('id', Auth::user()->role_id)->first()->name;
    }
}

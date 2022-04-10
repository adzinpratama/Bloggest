<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    public function sessionConfig(Request $request)
    {
        if ($request->has('switchToLayout')) {
            return Session::put('lightMode', $request->switchToLayout);
        }

        if ($request->has('toggleMenu')) {
            return Session::put('toggleMenu', $request->toggleMenu);
        }
    }
}

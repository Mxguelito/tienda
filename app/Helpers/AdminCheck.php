<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class AdminCheck
{
    public static function check()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Acceso no autorizado')->send();
        }
    }
}

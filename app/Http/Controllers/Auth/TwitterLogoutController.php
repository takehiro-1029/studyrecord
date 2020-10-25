<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TwitterLogoutController extends Controller
{
    public function getLogout() {
        Auth::logout();
        Session::flush();
        return redirect()->route('top');
    }
}
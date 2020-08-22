<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TwitterLogoutController extends Controller
{
    public function getLogout() {
        Auth::logout();
        return redirect()->route('top');
    }
}
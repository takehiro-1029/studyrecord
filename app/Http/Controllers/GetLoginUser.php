<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GetLoginUser extends Controller
{
    public static function getuserdata()
    {
        $login_user = [];
        $user = Auth::user()->where('id',Auth::id())->first();
        $login_user = [
            'user_name' => $user->user_name,
            'screen_name' => $user->screen_name,
            'profile_image_url' => $user->profile_image_url,
        ];
        return $login_user;
    }
}
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class DemoLoginController extends Controller
{
//    デモサイトログイン用(Twitter認証は行わずにログインさせる)
    
    private static function getUser()
    {
        $demo_user_id = config('services.demo.user_id');
        $demo_user = User::where('twitter_id', $demo_user_id)->first();
        
        return $demo_user->id;
    }
    
    public function Login() {
        
        session(['demo' => true]);
        
        Auth::loginUsingId(self::getUser());
        
        session()->flash('flash_message', "デモサイトにログインしました");
        
        return redirect('/calendar');
    }
}

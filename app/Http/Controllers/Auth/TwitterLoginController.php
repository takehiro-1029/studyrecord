<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use App\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;

class TwitterLoginController extends Controller
{
    public function redirectToProvider() {
        return Socialite::driver('twitter')->redirect();
    }

    public function handleProviderCallback() {
        
        try {
            $twitter_account = Socialite::driver('twitter')->user();
            $twitter_id = $twitter_account->id;
            
            $db_user = User::where('twitter_id', $twitter_id)->first();
            
//            登録済みのユーザーが判定
            if(is_null($db_user)) {
                // DBインサート
                $new_registered_user = new User([
                    'twitter_id' => $twitter_account->id,
                    'user_name' => $twitter_account->name,
                    'screen_name' => $twitter_account->nickname,
                    'profile_image_url' => $twitter_account->user['profile_image_url_https'],
                    'oauth_token' => $twitter_account->token,
                    'oauth_token_secret' => $twitter_account->tokenSecret,
                ]);
                
                $new_registered_user->save();
                
                \Auth::login($new_registered_user);
                
                return redirect('/');
            };
            
//            登録済みのユーザー情報を更新
            User::where('twitter_id',$twitter_id)->update([
                'user_name' => $twitter_account->name,
                'profile_image_url' => $twitter_account->user['profile_image_url_https'],
                'oauth_token' => $twitter_account->token,
                'oauth_token_secret' => $twitter_account->tokenSecret,
                'delete_flg' => false,
            ]);
            
//            どのデータと照合しているのか？
            Auth::login($db_user);
//            auth()->login($user, true);
            return redirect('/calendar');

        } catch (Exception $e) {
            Log::info($e->getMessage());
            session()->flash('flash_message', 'Twitterアカウント読み取りに失敗しました。');
            return redirect('/');
        }
    }
}
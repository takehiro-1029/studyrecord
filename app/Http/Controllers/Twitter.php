<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Abraham\TwitterOAuth\TwitterOAuth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\StudyRecord;
use Illuminate\Support\Facades\Session;

class Twitter extends Controller
{    
    public function welcome()
    {
        $user = Auth::user()->where('id',Auth::id())->first();
        
        dump($user->oauth_token);
                
        // access_tokenを用いてTwitterOAuthをinstance化
        $twitter = new TwitterOAuth(
            config('services.twitter.client_id'),
            config('services.twitter.client_secret'),
            $user->oauth_token,
            $user->oauth_token_secret
        );
        
        dump($twitter);
        
//        タイムライン
        $tweetTimeline = $twitter->get('statuses/user_timeline', array(
            'screen_name' =>  $user->screen_name,
            'exclude_replies' =>  true,
            'include_rts' =>  false,
            'count'  =>  10,
        ));
        
        if(!empty($tweetTimeline)) {
            for($i = 0; $i < count($tweetTimeline); $i++){
                $tweet_text = mb_convert_kana($tweetTimeline[$i]->text, 'kvrn');
                $tweet_time = Carbon::parse($tweetTimeline[$i]->created_at)->timezone('Asia/Tokyo');
                if(preg_match('/(\d+(?:\.\d+)?)h/i', $tweet_text, $match) && $tweet_time->isToday()){
                    dump((float) $match[1]);
                    dump($tweet_time);
                    dump($tweetTimeline[$i]->text);
                    $a = new StudyRecord([
                        'user_id' => Auth::id(),
                        'study_hours' => (float) $match[1],
                        'study_tweet' => $tweetTimeline[$i]->text,
                        'study_date' => $tweet_time,
                    ]);
                    $a->save();
                    dump($a);
                    continue;
                };
                echo $i;
            };
        };
        
        dump($tweetTimeline);
        
        return redirect()->route('calendar');
    }
    
    public function getTopPage()
    { 
        return view('top');
    }
    
    public function getHowToUse()
    { 
        
        return view('how_to_use',['userdata' => GetLoginUser::getuserdata()]);
    }
}

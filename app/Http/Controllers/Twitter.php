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
    
    public function get()
    {
        
        
        $study_record = new StudyRecord;     
        $follow_num = $study_record->join('users', 'users.id', '=', 'studyrecords.user_id')->where('user_id',Auth::id())->get();
        
//        日時範囲（1ヶ月）を指定してDBから取得
//        dump($follow_num);
//        
//        dump($follow_num[0]->study_hours);
//        dump($follow_num[0]->study_tweet);
//        dump($follow_num[0]->study_date);
        
//        $api_limit = $twitter->get('application/rate_limit_status', array(
//                'resources' => 'statuses',
//        ));
//        $t = new DateTime($tweetTimeline[0]->created_at);
//        $a = $t->setTimeZone(new DateTimeZone('Asia/Tokyo'))->format('Y/m/d');
        
//        dump($tweetTimeline[0]->text);
//        dump($tweetTimeline);
        
//         $date1 = Carbon::parse($follow_num[0]->study_date)->timezone('Asia/Tokyo')->format('Y-m-j');
//        $date2 = Carbon::parse($follow_num[1]->study_date)->timezone('Asia/Tokyo')->format('Y-m-j');
//        $date2 = Carbon::parse($follow_num[1]->study_date)->format('Y-m-j');
//        $user_db = array(['day'=>$follow_num[0]->study_date, 'hours'=>$follow_num[0]->study_hours],['day'=>$date2, 'hours'=>2]);
        
        return view('top');
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Abraham\TwitterOAuth\TwitterOAuth;
use App\User;
use App\StudyRecord;
use Carbon\Carbon;
use Log;
use \Exception;

class GetUserTweet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:getusertweet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get the user tweet from twitter';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        set_time_limit(0);
        
        Log::debug(Carbon::now()."ツイート取得開始");
        
        try{
            $get_users = User::orderBy('id', 'asc')->where('day_update_flg', 0)->where('delete_flg', 0)->get();
            
            Log::debug(count($get_users)."ユーザー取得");

    //        該当ユーザーがいなければ処理終了
            if(count($get_users) === 0){
                Log::debug('取得ユーザーなし終了');
                return;  
            };

    //         対象user分ループを回す
            for ($i = 0; $i < count($get_users); $i++) {
                
                Log::debug("ユーザーID:".$get_users[$i]->id);

                $twitter_access = '';
                $tweet_timeline = '';

    //            access_tokenを用いてTwitterOAuthをinstance化
                $twitter_access = self::twitter_access($get_users[$i]->oauth_token, $get_users[$i]->oauth_token_secret);

    //            タイムライン取得
                $tweet_timeline = self::get_tweet_timeline($twitter_access, $get_users[$i]->screen_name);

                if(!empty($tweet_timeline)) {

                    for($j = 0; $j < count($tweet_timeline); $j++){

                        $study_tweet = [];
                        Log::debug(($j+1)."回目のツイート取得");

                        if(!empty($study_tweet = self::judge_user_timeline($tweet_timeline[$j]))){

                            self::save_user_tweet($get_users[$i]->id, $study_tweet[0], $tweet_timeline[$j]->full_text, $study_tweet[2]);
                            Log::debug(($j+1)."回目のツイートをStudyRecordにデータ挿入完了");

                        }; 
                    };
                };

                sleep(10);
            };

        }catch(Exception $e){
            Log::debug($e->getMessage());
            Log::debug("DBに接続できませんでした。");
            return false;
        };
        
        Log::debug("処理終了");
    }
    
    
    private static function judge_user_timeline($user_timeline)
    {
        $tweet_text = mb_convert_kana($user_timeline->full_text, 'kvrn');
        $tweet_time = Carbon::parse($user_timeline->created_at)->timezone('Asia/Tokyo');
        
        if(preg_match('/(\d+(?:\.\d+)?)h/i', $tweet_text, $match) && $tweet_time->isYesterday()){
            $study_hour = (float) $match[1];
            return [$study_hour, $tweet_text, $tweet_time];
        };
        
        return;
    }
    
    private static function twitter_access($oauth_token, $oauth_token_secret)
    {
        $twitter_access = '';
        
        try{
            $twitter_access = new TwitterOAuth(
                config('services.twitter.client_id'),
                config('services.twitter.client_secret'),
                $oauth_token,
                $oauth_token_secret
            );
            
            return $twitter_access;
            
        }catch(Exception $e){
            Log::debug($e->getMessage());
            Log::debug("twitterに接続できませんでした。");
        }
        
        
    }
    
    private static function get_tweet_timeline($twitter_access, $screen_name)
    {
        $tweetTimeline = '';
        
        $tweetTimeline = $twitter_access->get('statuses/user_timeline', array(
            'screen_name' =>  $screen_name,
            'exclude_replies' =>  true,
            'include_rts' =>  false,
            'trim_user' =>  true,
            'count'  =>  10,
            'tweet_mode' => 'extended',
        ));
        
//        配列であればtweetデータが入っている、オブジェクトであれば接続エラーが出てる
        if(is_array($tweetTimeline)) {
            Log::debug(count($tweetTimeline)."tweetを取得しました。");
            return $tweetTimeline;
        }else{
            Log::debug("tweetを取得できませんでした。");
            User::where('screen_name',$screen_name)->update([
                'delete_flg' => true,
            ]);
            Log::debug($screen_name."のdelete_flgをtrueにしました。");
            return;
        }
    }
    
    private static function save_user_tweet($user_id, $study_hours, $study_tweet, $study_date)
    {
        $user_tweet = '';
        
        try{
            $user_tweet = new StudyRecord([
                    'user_id' => $user_id,
                    'study_hours' => $study_hours,
                    'study_tweet' => $study_tweet,
                    'study_date' => $study_date,
            ]);

            $user_tweet->save();
            return;
            
        }catch(Exception $e){
            Log::debug($e->getMessage());
            Log::debug("DBに接続できませんでした。");
        }
    }
}

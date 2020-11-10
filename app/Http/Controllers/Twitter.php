<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Abraham\TwitterOAuth\TwitterOAuth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\StudyRecord;
use Illuminate\Support\Facades\Session;
use Exception;
use Illuminate\Support\Facades\Log;
use DB;

class Twitter extends Controller
{    
    public function getTopPage()
    {
        $firstday = Carbon::now()->subMonth(3)->firstOfMonth()->format('Y-m-d');
        $lastday = Carbon::now()->subMonth(3)->lastOfMonth()->format('Y-m-d');
        
        $user_studyhour_ranking = DB::select("
            SELECT 
            studyrecords.user_id, Sum(studyrecords.study_hours) as study_hours, users.twitter_id, users.user_name, users.profile_image_url, users.screen_name FROM studyrecords 
            INNER JOIN users ON studyrecords.user_id = users.id 
            WHERE studyrecords.study_date >= :firstday AND studyrecords.study_date <= :lastday
            GROUP BY studyrecords.user_id
            ORDER BY study_hours DESC
            LIMIT 3
        ", ['firstday' => $firstday, 'lastday' => $lastday]);
        
//        dump($user_studyhour_ranking);
        
        return view('top',['user_studyhour_ranking' => $user_studyhour_ranking]);
    }
    
    public function getHowToUse()
    {
        return view('how_to_use',['userdata' => GetLoginUser::getuserdata()]);
    }
    
    public function getSavePage()
    {   
        return view('save_record',['userdata' => GetLoginUser::getuserdata()]);
        
    }
    
    public function getEditPage($id)
    {
        $edit_record = Auth::user()->studyRecord()->find($id);
        
        if(!($edit_record)){
            return redirect('calendar')->with('flash_message', __('Invalid operation was performed.'));
        }
        
        return view('edit_record',['edit' => $edit_record, 'userdata' => GetLoginUser::getuserdata()]);
        
    }
    
    public function DeleteRecord($id)
    {
        self::is_demo();
        
        // GETパラメータが数字かどうかをチェックする
        if(!ctype_digit($id)){
            return redirect('calendar')->with('flash_message', __('Invalid operation was performed.'));
        }
        
        Auth::user()->studyRecord()->find($id)->delete();

        return redirect('calendar')->with('flash_message', __('Deleted.'));
        
    }
    
    public function SaveRecord(Request $request, $id = 0)
    {
        self::is_demo();

        $request->validate([
            'date' => 'date|required|before:tomorrow',
            'hour' => 'numeric|required|min:0.1|max:24',
            'contents' => 'required|string|min:8|max:140',
        ]);

        $user_id = Auth::id();
        $date = $request->input('date');
        $hour = $request->input('hour');
        $contents = $request->input('contents');

        //DBから取り出して指定月の合計が24hを超える場合はエラーを出す
        $db_sum_hours = User::join('studyrecords', 'studyrecords.user_id', '=', 'users.id')->where('user_id',$user_id)->where('study_date', $date)->sum('study_hours');

        if($id === 0){

            $sum_hours = $db_sum_hours + $hour;

            self::judge_hour($sum_hours);

            $db_input = new StudyRecord([
                'user_id' => $user_id,
                'study_hours' => $hour,
                'study_tweet' => $contents,
                'study_date' => $date,
            ]);

            $db_input->save();

            session()->flash('flash_message', "データを新規登録しました");

        }else{

            $db_provsave_hours = StudyRecord::where('id',$id)->sum('study_hours');

            $sum_hours = $db_sum_hours + ($hour - $db_provsave_hours);

            self::judge_hour($sum_hours);  

            $db_update = StudyRecord::where('id','=', $id)->update([
                'study_hours' => $hour,
                'study_tweet' => $contents,
                'study_date' => $date,
            ]);

            session()->flash('flash_message', "データを編集しました");

        }

        return redirect('calendar');
        
    
    }
    
    private static function judge_hour($hours)
    {
        if(round($hours,1) > 24){
            
            return redirect('calendar')->with('flash_message', "合計が24hを超えているため保存できませんでした")->throwResponse();
        }
        
        return;
    }
    
    private static function is_demo()
    {
        $is_demo = session()->has('demo');
            
        if($is_demo){
            return redirect('calendar')->with('flash_message', __('this account is demo.'))->throwResponse();
        }
        
        return;
    }
}

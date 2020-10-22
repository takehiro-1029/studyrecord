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
    public function getTopPage()
    { 
        return view('top');
    }
    
    public function getHowToUse()
    { 
        
        return view('how_to_use',['userdata' => GetLoginUser::getuserdata()]);
    }
    
    public function getSavePage()
    { 
        
        return view('save_record',['userdata' => GetLoginUser::getuserdata()]);
        
    }
    
    public function getSaveRecord(Request $request)
    {
        
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
        $db_sum_hours = StudyRecord::join('users', 'users.id', '=', 'studyrecords.user_id')->where('user_id',$user_id)->where('study_date', $date)->sum('study_hours');
        
        $sum_hours = $db_sum_hours + $hour;
        
        if(round($sum_hours,1) > 24){
            session()->flash('flash_message', "合計が24hを超えているため保存できませんでした。");
            
        }else{
            $db_input = new StudyRecord([
                'user_id' => $user_id,
                'study_hours' => $hour,
                'study_tweet' => $contents,
                'study_date' => $date,
            ]);

            $db_input->save();
            
            session()->flash('flash_message', "データを新規登録しました。");
        }
        
        return redirect('calendar');
    }
    
}

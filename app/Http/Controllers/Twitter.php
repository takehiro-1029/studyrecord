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
        
        $date = $request->input('date');
        $hour = $request->input('hour');
        $contents = $request->input('contents');
        
        dd();
        
        $db_input = new StudyRecord([
            'user_id' => Auth::id(),
            'study_hours' => $hour,
            'study_tweet' => $contents,
            'study_date' => $date,
        ]);
        
        $db_input->save();
        dump($a);
        dd(Auth::id());
    }
    
}

<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\StudyRecord;

class CalendarService
{
    /**
     * カレンダーデータを返却する
     *
     * @return array
     */
        
    public function getWeeks()
    {
        $weeks = [];
        $week = '';
        $summarize_user_study_record = array();

        $dt_firstday = new Carbon(self::getYm_firstday());//2020-07-01
        $day_of_week = $dt_firstday->dayOfWeek;     // 曜日
        $days_in_month = $dt_firstday->daysInMonth; // その月の日数
        
        $user_study_record = self::get_user_record(Auth::id());
        
        $summarize_user_study_record = self::summarize_user_record($user_study_record,$summarize_user_study_record);
        
        // 第 1 週目に空のセルを追加
        $week .= str_repeat('<td></td>', $day_of_week);

        for ($day = 1; $day <= $days_in_month; $day++, $day_of_week++) {
            $date = self::getYm() . '-' . $day;
            if (Carbon::now()->format('Y-m-j') === $date) {
                $week .= '<td class="p-calendar__content-table-day p-calendar__content-table-today">';
            } else {
                $week .= '<td class="p-calendar__content-table-day">';
            }
            $week .= '<div class="p-calendar__content-table-day-form" data-dayid="'.$date.'">'. $day . '</div>';
            $div_add_flg = true;
            foreach($summarize_user_study_record as $key => $val) {
                if ($val['day'] === $date){
                    $week .= '<div class="p-calendar__content-table-day-form p-calendar__content-table-day-form-bgcolor">'.$val['hours'].'h'.'</div>';
                    $div_add_flg = false;
                }
            }
            if ($div_add_flg === true){
                $week .= '<div class="p-calendar__content-table-day-form"></div>';
            }
            $week .= '</td>';

            // 週の終わり、または月末
            if (($day_of_week % 7 === 6) || ($day === $days_in_month)) {
                if ($day === $days_in_month) {
                    $week .= str_repeat('<td></td>', 6 - ($day_of_week % 7));
                }
                $weeks[] = '<tr class="p-calendar__content-table-weekdays">' . $week . '</tr>';
                $week = '';
            }
        }
        return $weeks;
    }

    /**
     * month 文字列を返却する
     *
     * @return string
     */
    public function getMonth()
    {
        return Carbon::parse(self::getYm_firstday())->format('Y-n');
    }

    /**
     * prev 文字列を返却する
     *
     * @return string
     */
    public function getPrev()
    {
        return Carbon::parse(self::getYm_firstday())->subMonthsNoOverflow()->format('Y-m');
    }

    /**
     * next 文字列を返却する
     *
     * @return string
     */
    public function getNext()
    {
        return Carbon::parse(self::getYm_firstday())->addMonthNoOverflow()->format('Y-m');
    }
    
    /**
     * next 文字列を返却する
     *
     * @return string
     */
    public function getChartData()
    {
        $user_record = self::get_user_record(Auth::id());
        $summarize_user_record['day'] = array();
        $summarize_user_record['hours'] = array();
        $summarize_user_record['sum'] = array();
        
        for ($i=0; $i<count($user_record); $i++){
            $study_date = Carbon::parse($user_record[$i]->study_date)->format('Y-m-d');
            $study_hours = $user_record[$i]->study_hours;
//            $key_of_duplicated_date = array_search($study_date, array_column($summarize_user_record, 'day'));
            $key_of_duplicated_date = array_search($study_date, $summarize_user_record['day']);
        if($key_of_duplicated_date !== false){
            $summarize_user_record['hours'][$key_of_duplicated_date] = $summarize_user_record['hours'][$key_of_duplicated_date] + $study_hours;
        }else{
            $summarize_user_record['day'][$i] = $study_date;
            $summarize_user_record['hours'][$i] = $study_hours;
        };
        };
        
        $summarize_user_record['day'] = array_values($summarize_user_record['day']);
        $summarize_user_record['hours'] = array_values($summarize_user_record['hours']);
        
        foreach($summarize_user_record['hours'] as $key => $value){
            if ($key === 0){
                $summarize_user_record['sum'][$key] = $value;
            }else{
                $summarize_user_record['sum'][$key] = $summarize_user_record['sum'][$key-1] + $value;  
            }
        };
        
        return $summarize_user_record;
    }
    
    /**
     * next 文字列を返却する
     *
     * @return string
     */
    public function getViewData()
    {
        $view_user_record = array();
        $view_user_record_count_hours = 0;
        $view_user_record_count_tweet = 0;
        
        $user_record = self::get_user_record(Auth::id());
        
        $view_user_record_count_hours = $user_record->sum('study_hours');
        $view_user_record_count_tweet = count($user_record);
        
        for ($i=0; $i<$view_user_record_count_tweet; $i++){
            $study_date = Carbon::parse($user_record[$i]->study_date)->format('Y-m-j');
            $study_hours = $user_record[$i]->study_hours;
            $study_tweet = $user_record[$i]->study_tweet;
            
            $view_user_record[$i]['day'] = $study_date;
            $view_user_record[$i]['hours'] = $study_hours;
            $view_user_record[$i]['tweet'] = $study_tweet;
        };
        
        return [$view_user_record, $view_user_record_count_hours, $view_user_record_count_tweet];
    }
    
    /**
     * GET から Y-m フォーマットを返却する
     *
     * @return string
     */
    private static function getYm()
    {
        if (isset($_GET['ym'])) {
            return $_GET['ym'];
        }
        return Carbon::now()->format('Y-m');
    }

    /**
     * 2019-09-01 のような月初めの文字列を返却する
     *
     * @return string
     */
    private static function getYm_firstday()
    {
        return self::getYm() . '-01';
    }
    
    /**
     * 2019-09-30 のような月最後の文字列を返却する
     *
     * @return string
     */
    private static function getYm_lastday()
    {
        $get_month = new Carbon(self::getYm_firstday());
        $last_day = $get_month->daysInMonth;
        return self::getYm() . '-'. $last_day;
    }
    
    /**
     * DBテーブルからログインユーザーの1ヶ月間の勉強記録を取り出す
     *
     * @return array
     */
    private static function get_user_record($user_id)
    {
        $firstday = new Carbon(self::getYm_firstday());//2020-07-01
        $lastday = new Carbon(self::getYm_lastday());//2020-07-31
        
        $user_record = StudyRecord::join('users', 'users.id', '=', 'studyrecords.user_id')->where('user_id',$user_id)->whereBetween('study_date', [$firstday, $lastday])->orderBy('study_date', 'asc')->get();
        
        return $user_record;
    }
    
    /**
     * カレンダー表示用に同じ日程の勉強時間をまとめる
     *
     * @return array
     */
    private static function summarize_user_record($user_record,$summarize_user_record)
    {
        for ($i=0; $i<count($user_record); $i++){
            $study_date = Carbon::parse($user_record[$i]->study_date)->format('Y-m-j');
            $study_hours = $user_record[$i]->study_hours;
            $key_of_duplicated_date = array_search($study_date, array_column($summarize_user_record, 'day'));
            if($key_of_duplicated_date !== false){
                $summarize_user_record[$key_of_duplicated_date]['hours'] = $summarize_user_record[$key_of_duplicated_date]['hours'] + $study_hours;
            }else{
                array_push ($summarize_user_record,['day'=>$study_date, 'hours'=>$study_hours]);
            };
        };
        
        return $summarize_user_record;
    }
}
<?php

namespace App\Http\Controllers;

use App\Facades\Calendar;
use App\Services\CalendarService;
use Illuminate\Http\Request;
use App\Http\Controllers\TwitterController;

class CalendarController extends Controller
{
    private $service;

    public function __construct(CalendarService $service)
    {
        $this->service = $service;
    }
    
    public function index()
    {
        return view('calendar', [
            'weeks'         => Calendar::getWeeks(),
            'month'         => Calendar::getMonth(),
            'prev'          => Calendar::getPrev(),
            'next'          => Calendar::getNext(),
            'chartdata'     => Calendar::getChartData(),
            'viewdata'      => (Calendar::getViewData())[0],
            'count_hours'   => (Calendar::getViewData())[1],
            'count_tweet'   => (Calendar::getViewData())[2],
            'userdata'      => GetLoginUser::getuserdata(),
        ]);
    }
}
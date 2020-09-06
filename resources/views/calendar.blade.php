@extends('layouts.app')

@include('layouts.header_main')

@section('content')
<main class="l-main">
    <div class="l-main-wrapper">
        <div class="p-studyrecord">
            <div class="p-studyrecord__content">
                <p class="p-studyrecord__content-title">期間</p>
                <p class="p-studyrecord__content-num"> {{ $month }}</p>
            </div>
            <div class="p-studyrecord__content">
                <p class="p-studyrecord__content-title">総学習時間(h)</p>
                <p class="p-studyrecord__content-num">{{ $count_hours }}</p>
            </div>
            <div class="p-studyrecord__content">
                <p class="p-studyrecord__content-title">総ツイート数</p>
                <p class="p-studyrecord__content-num">{{ $count_tweet }}</p>
                
                <a href="https://twitter.com/intent/tweet?text=期間:{{ $month }}%0D%0A学習時間:{{ $count_hours }}h%0D%0Aツイート数:{{ $count_tweet }}%0D%0Ahttps://studynrecord.com">aaaaaaaa</a>
            </div>
        </div>

        <div class="p-calendar">

            <div class="p-calendar__month">
                <a class="p-calendar__month-prev js-scroll_top" href="?ym={{ $prev }}">&lt;</a>
                <span class="p-calendar__month-now">{{ $month }}</span>
                <a class="p-calendar__month-next js-scroll_top" href="?ym={{ $next }}">&gt;</a>
            </div>

            <div class="p-calendar__content">
                <table class="p-calendar__content-table">
                    <tr class="p-calendar__content-table-day_of_week">
                        <th class="p-calendar__content-table-day_of_week-txt">日</th>
                        <th class="p-calendar__content-table-day_of_week-txt">月</th>
                        <th class="p-calendar__content-table-day_of_week-txt">火</th>
                        <th class="p-calendar__content-table-day_of_week-txt">水</th>
                        <th class="p-calendar__content-table-day_of_week-txt">木</th>
                        <th class="p-calendar__content-table-day_of_week-txt">金</th>
                        <th class="p-calendar__content-table-day_of_week-txt">土</th>
                    </tr>
                    @foreach ($weeks as $key => $week)
                    {!! $week !!}
                    @endforeach
                </table>
            </div>
        </div>
    </div>


    <div id="app">
        <index-chart :chartdata="{{ json_encode($chartdata) }}" :month="{{ json_encode($month) }}"></index-chart>
    </div>

    <div class="p-tweet">
        @foreach ($viewdata as $key => $data)
        <div class="p-tweet__box">
            <div class="p-tweet__box__study">
                <div class="p-tweet__box__study-day">{{$data['day']}}</div>
                <div class="p-tweet__box__study-hour">{{$data['hours']}} <span>h</span></div>
            </div>
            <div class="p-tweet__box__text">{!! nl2br(e($data['tweet'])) !!}</div>
        </div>
        @endforeach
    </div>
</main>
@endsection

@include('layouts.footer')
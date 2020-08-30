@extends('layouts.app')

@include('layouts.header_main')

@section('content')
<main class="l-main">
    <div class="p-use">

        <h1 class="p-use__title">データ収集を行う対象Tweet</h1>
        
        <div class="p-use__header">
            <h1>どういうTweetが収集されるのか？</h1>
            <p>Tweet文章に2hのような数字+hの記載がある場合に対象となります</p>
        </div>

        <div class="p-use__main">
            <div class="p-use__main__section">
                <div class="p-use__main__section__OK">
                    <h1>OKパターン</h1>
                    <p>2h←学習時間の後ろにhの記載がある</p>
                    <p>※&ensp;前後に文字があっても収集します</p>
                </div>

                <div class="p-use__main__section__NG">
                    <h1>NGパターン</h1>
                    <p>2&ensp;h←数値とhとの間に空白や改行がある</p>
                </div>
            </div>

            <div class="p-use__main__img"><img src="{{ asset('/img/main_how_to_use.jpeg') }}" alt=""></div>
        </div>

        <div class="p-use__sub">
            <h1>補足事項</h1>
            <ul>
                <li>1つのTweetに複数学習時間の記載がある場合は最初の数値のみ収集します</li>
                <li>1日5Tweetまで収集できます</li>
                <li>対象Tweetに関しては内容も全て収集します</li>
                <li>収集したTweetをユーザーに許可なく拡散したり悪用することはございません</li>
            </ul>
        </div>
    </div>
    
    <div class="p-use-btn">
        <a class="p-use-btn-back" href="{{ route('calendar') }}">
            戻る
        </a>
    </div>

</main>
@endsection

@include('layouts.footer')

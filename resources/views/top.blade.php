@extends('layouts.app')

@include('layouts.header_top')

@section('content')

<main class="l-main__top">
    <div class="p-top">
        <div class="p-top__header js-top_header-animation">
            <img src="{{ asset('/img/top_msg.jpg') }}" alt="">
            <div class="p-top__header__message">学習記録を自動化しよう</div>
            <div class="p-top__header__btn">
                <a class="p-top__header__btn-register" href="{{ route('login') }}">
                  記録を確認
                </a>
            </div>
        </div>

        <div class="p-top__main">

            <div class="p-top__main__canDo js-top_main-animation">
                <div class="p-top__main__canDo-message">StudyRecordでできること</div>
                <div class="p-top__main__canDo-detaill">学習進捗Tweetを自動で収集し、学習内容の振り返りが簡単にできます。</div>
                <img class="p-top__main__canDo-img-pc" src="{{ asset('/img/top_explanation_pc.jpg') }}" alt="">
                <img class="p-top__main__canDo-img-sp" src="{{ asset('/img/top_explanation_sp.jpg') }}" alt="">
            </div>

            <div class="p-top__main__recommend js-top_main-animation">
                <div class="p-top__main__recommend-message">こんな方におすすめ</div>
                <div class="p-top__main__recommend-detaill">
                    <img src="{{ asset('/img/top_recommend.jpeg') }}" alt="">
                    <div class="p-top__main__recommend-detaill-list">
                        <ul>
                            <li><i class="fas fa-check-square fa-lg fa-fw"></i>学習時間を簡単に記録したい</li>
                            <li><i class="fas fa-check-square fa-lg fa-fw"></i>進捗Tweetを記録として残したい</li>
                            <li><i class="fas fa-check-square fa-lg fa-fw"></i>学習Tweetを簡単に振り返りたい</li>
                            <li><i class="fas fa-check-square fa-lg fa-fw"></i>Twitterのフォロワーを増やしたい</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="p-top__main__section js-top_main-animation">
              <div class="p-top__main__section__content">
                <img src="{{ asset('/img/top_benefit1.jpeg') }}" alt="">
                <div>簡単登録</div>
                <p>Twitterアカウントで登録できます。<br>メールアドレスは必要ありません。</p>
              </div>
              <div class="p-top__main__section__content">
                <img src="{{ asset('/img/top_benefit2.jpeg') }}" alt="">
                <div>学習Tweetを自動収集</div>
                <p>1日1回、Tweetを自動集計します。<br>Tweetはいつでも確認できます。</p>
              </div>
              <div class="p-top__main__section__content">
                <img src="{{ asset('/img/top_benefit3.jpeg') }}" alt="">
                <div>学習内容を簡単確認</div>
                <p>カレンダー、グラフ機能で月ごとの<br>学習内容を簡単に確認できます。</p>
              </div>
            </div>

            <div class="js-top_main-animation">
                <div class="p-top__main__section__btn">
                    <a class="p-top__main__section__btn-register" href="{{ route('login') }}">
                        無料登録はこちらから
                    </a>
                </div>
            </div>
        </div>

    </div>
</main>

@endsection

@include('layouts.footer')

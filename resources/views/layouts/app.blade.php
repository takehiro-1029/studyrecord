<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tweetのみで学習を記録できる||StudyRecord</title>
    <meta name="description" content="学習Tweetを自動で収集し学習内容の振り返りが簡単にできます。毎日頑張っているあなたを支援するサービスです。Twitterアカウントのみで登録ができ、今なら全て無料で利用できます。" />
    <meta name="keywords" content="学習記録,Twitter,駆け出しエンジニア">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'StudyRecord') }}</title>
    
    <!-- Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://use.fontawesome.com/releases/v5.0.6/js/all.js" defer></script>

    <!-- Fonts -->
<!--
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
-->

    
</head>

<body>
    <!-- フラッシュメッセージ -->
    @if (session('flash_message'))
    <div class="c-flash-message js-flash-message">
        {{ session('flash_message') }}
    </div>
    @endif

    @yield('header')

    @yield('menubar')

    @yield('content')

    @yield('footer')

</body>

</html>
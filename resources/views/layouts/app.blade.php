<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tweetのみで学習を記録できる||StudyRecord</title>
    <meta name="description" content="仮想通貨トレンド情報を独自方法で解析し無料で提供しています。仮想通貨に関する最新ニュースも閲覧可能、自動フォロー機能で仮想通貨に特化したTwitter運用もお任せください。" />
    <meta name="keywords" content="学習記録,Twitter,駆け出しエンジニア">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'StudyRecord') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://use.fontawesome.com/releases/v5.0.6/js/all.js" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
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
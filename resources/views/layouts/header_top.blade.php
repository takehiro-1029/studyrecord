@section('header')
<header id="l-header" class="l-header_top">
    <div class="p-header_top js-top_header-animation">
       
        <h1 class="p-header_top__logo">
            <a href="{{ route('top') }}">{{ __('StudyRecord') }}</a>
        </h1>
        
        <div class="p-header_top__btn">
            <div class="p-header_top__btn-login">
                <a class="p-header_top__btn-login-btn" href="{{ route('login') }}">{{ __('Login') }}</a>
            </div>
        </div>
        
    </div>
</header>
@endsection
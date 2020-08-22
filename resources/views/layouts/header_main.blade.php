@section('header')
<header id="l-header" class="l-header_main">
    <div class="p-header_main">
       
        <h1 class="p-header_main__logo">
            <a href="">StudyRecord</a>
        </h1>
        
        <div class="p-header_main__username js-hover">
            <span><i class="fas fa-user fa-2x fa-fw"></i></span>
            <p>{{ $userdata['user_name'] }} さん</p>
        </div>
        
        <div class="p-header_main__actions js-show">
            <div class="p-header_main__actions__user">
                <div class="p-header_main__actions__user-img"><img src="{{ $userdata['profile_image_url'] }}" /></div>
                <div class="p-header_main__actions__user-name">{{ $userdata['screen_name'] }} </div>
            </div>
            <div class="p-header_main__actions__btn ">
                <a href="{{ route('logout') }}">
                    {{ __('Logout') }}
                </a>
            </div>
        </div>

        <div class="p-header_main__menu-trigger js-toggle-sp-menu">
            <span></span>
            <span></span>
            <span></span>
        </div>
        
        <nav class="p-header_main__nav js-toggle-sp-menu-target">
            <div class="p-header_main__nav__user">
                <div class="p-header_main__nav__user-img"><img src="{{ $userdata['profile_image_url'] }}" /></div>
                <div class="p-header_main__nav__user-name">{{ $userdata['user_name'] }}さん</div>
            </div>
            <div class="p-header_main__nav__btn ">
                <a href="{{ route('logout') }}">
                    {{ __('Logout') }}
                </a>
            </div>
        </nav>

    </div>
</header>
@endsection
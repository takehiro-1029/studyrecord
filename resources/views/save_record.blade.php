@extends('layouts.app')

@include('layouts.header_main')

@section('content')
<main class="l-main">

<div class="p-register">

    <h1 class="p-register__title">学習記録登録</h1>

    <div class="p-register__form">

        <form action="{{ url('/save_record')}}" method="POST">
            {{ csrf_field() }}

            <div class="p-register__form-day">
                <p>日時</p>
                <input type="date" name="date" value="{{ old('date') }}" autofocus required>
                @if ($errors->has("date"))
                <strong>{{ $errors->first('date') }}</strong>
                @endif
            </div>

            <div class="p-register__form-hour">
                <p>時間(hour)</p>
                <input type="number" name="hour" value="{{ old('hour') }}" min="0.1" max="24" step="0.1" required>
                @if ($errors->has("hour"))
                <strong>{{ $errors->first('hour') }}</strong>
                @endif
            </div>

            <div class="p-register__form-content">
                <p>内容</p>
                <textarea name="contents" cols="40" rows="5" maxlength="140" placeholder="8文字以上140文字以内でご記入ください" required>{{ old('contents') }}</textarea>
                @if ($errors->has("contents"))
                <strong>{{ $errors->first('contents') }}</strong>
                @endif
            </div>

            <input class="p-register__form-submit" type="submit" value="登録する">
        </form>


    </div>

</div>


</main>
@endsection

@include('layouts.footer')

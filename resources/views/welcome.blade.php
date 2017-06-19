<!doctype html>
<html lang="{{ config('app.locale') }}">
@include('layouts.partials._head')
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="links">
                    <div class="homeButtonWrapper">
                        @if (Auth::check())
                            <a class='homeButton' href="{{ url('/home') }}">HOME</a>
                        @else
                            <a class='registerButton' href="{{ url('/register') }}">REGISTER</a>
                            <a class='loginButton' href="{{ url('/login') }}">LOGIN</a>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@include('layouts.partials._head')

<body>
    <div id="app">
    @include('layouts.partials._nav')

        <div class="copySuccess alert alert-success col-md-3">
            Address Copied to Clipboard!
        </div>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>

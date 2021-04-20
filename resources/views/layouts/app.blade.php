<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ProfileHUD') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Styles -->
        <link rel="icon" href="{{ URL::asset('/favicon.png') }}" type="image/x-icon"/>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    </head>

    <body style="padding-bottm: 20px; background-color: whitesmoke; background-image: url('/svg/background.png'); ">

        @include ('layouts.nav')

        <div style="padding-top: 25px;">

            @yield('content')

        </div>

    </body>

    <footer class="text-center" id="footer">
        <i><small>2021 ProfileHUD Team. Visit us on <a href="https://github.com/ProfileHUD-Team/ProfileHUD">GitHub</a>.
                All names and images are copyright to their respective owners.
            ProfileHUD has no affiliation with Valve or Microsoft.</small></i>
    </footer>
</html>

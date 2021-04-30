
<!--

    This file holds the code that serves as the basic layout that all other view pages inherits.
    All other view pages are built off of this layout page.
    edited: Eric Cortes
    package: /resources/views/layouts

-->

<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <!-- This is the head of the layouts page -->
    <head>

        <!-- Background image of the layout pate -->
        <meta property="og:image" content="/svg/test2.png" />
        <meta property="og:description" content="Your one-stop destination for game and achievement tracking." />
        <meta charset="utf-8">

        <!-- Ability for the page to be responsive to device screen size -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Website title -->
        <title>{{ config('app.name', 'ProfileHUD') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Styles -->
        <link rel="icon" href="{{ URL::asset('/favicon.png') }}" type="image/x-icon"/>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    </head>

    <!-- Body of the layouts page -->
    <body style="padding-bottm: 20px; background-color: whitesmoke; background-image: url('/svg/background.png'); ">

        <!-- Inheriting the navigation bar -->
        @include ('layouts.nav')

        <!-- Section of code were all other view pages begin -->
        <div style="padding-top: 25px;">

            <!-- Field where the content of other view pages goes -->
            @yield('content')

        </div>

    </body>

    <!-- Footer of layouts page -->
    <footer class="text-center" id="footer">

        <!-- Content of footer -->
        <i><small>

            2021 ProfileHUD Team. Visit us on
            <a href="https://github.com/ProfileHUD-Team/ProfileHUD">GitHub</a>.
            All names and images are copyright to their respective owners.
            ProfileHUD has no affiliation with Valve or Microsoft.

        </small></i>

    </footer>

</html>

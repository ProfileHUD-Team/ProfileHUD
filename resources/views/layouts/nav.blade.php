<!--

    This file holds the code that creates the navigation bar of the website.
    Any modification done to the navigation bar should be done here and
    this will update all the navigation bars on all the view pages
    edited: Eric Cortes
    package: /resources/views/layouts

-->

<!-- Navigation Bar Class and Color -->
<nav class="navbar navbar-expand-md navbar-light shadow-sm" style="background-color:#F1F1F1">

    <!-- Container that holds the navigation bar -->
    <div class="container">

        <!-- Website logo found at the left most part of the navigation bar-->
        <a class="navbar-brand" href="{{ url('/home') }}">

            <!-- Image used for the website logo-->
            <img src="/svg/test2.svg" class="img-fluid" style ="height: 25px; width: 105px">

        </a>

        <!-- Navigation toggle -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">

            <span class="navbar-toggler-icon"></span>

        </button>

        <!-- Contents of navigation bar -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Authentication Links -->
                @guest

                    <!-- Login in link for a user who is not logged in -->
                    @if (Route::has('login'))

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>

                        </li>

                    @endif

                    <!-- Register link for a user who is not logged in -->
                    @if (Route::has('register'))

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>

                        </li>

                    @endif

                    <!-- About us page linki for when the user is not logged in-->
                    <a class= "nav-link" href="{{ url('/aboutus') }}">About Us</a>

                @else

                    <li class="nav-item dropdown">

                        <!-- Obtain the user name one logged in-->
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>

                            {{ Auth::user()->name }}

                        </a>

                        <!-- Navigation bar dropdown contents once logged in-->
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                            <!-- Link in the dropdown menu to go to the profile page-->
                            <a class="dropdown-item" href="{{ url('/home') }}">

                                {{ __('Profile') }}

                            </a>

                            <!-- Link in the dropdown menu to go to the settings page-->
                            <a class="dropdown-item" href="{{ url('/settings') }}">

                                {{ __('Settings') }}

                            </a>

                            <!-- Link in the dropdown menu to go to the about us page-->
                            <a class="dropdown-item" href="{{ url('/aboutus') }}">

                                {{ __('About Us') }}

                            </a>

                            <!-- Link in the dropdown menu to log out-->
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                                {{ __('Logout') }}

                            </a>

                            <!-- Form for when user is logged out-->
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">

                                @csrf

                            </form>

                        </div>

                    </li>

                @endguest

            </ul>

        </div>

    </div>

</nav>

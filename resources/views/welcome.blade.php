
<!--

    This view page is the initial view page a user sees whenever they first open the website.
    edited: Eric Cortes
    package: /resources/views

-->


<!-- Inherits layouts page-->
@extends('layouts.app')


<!-- Section of code for the welcome page -->
@section('content')

    <!-- Image that is displayed in the center of the welcome page -->
    <div class="row justify-content-center">

        <!-- Image -->
        <img src="/svg/test.svg" class="img-fluid mw-100" style =" min-width: 200px">

    </div>

    <!-- Content that is found at the center of the screen -->
    <div class="text-center">

        <h5>
            This is your one-stop destination for viewing and tracking your gaming achievements.
            <br/>
            View all of your games and see how many achivements you have completed!</h5>
        <img src="/svg/home_example.png" class="img-fluid mw-100" style="">
        <h5><br/>
           Check which achievements still need to be completed, and how to earn them!
        </h5>
        <img src="/svg/game_example.png" class="img-fluid mw-100" style="">
    </div>

@endsection

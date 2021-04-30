<!--
    This view page is the is the page where a brief description of the website is.
    edited: Eric Cortes
    package: /resources/views
-->

<!-- Inherits the layouts page -->
@extends('layouts.app')

<!-- Section of code that pertains to this view page -->
@section('content')

    <!-- Container that displays the content of this view page-->
    <div class="container">

        <!-- Positioning of the content on the page-->
        <div class="row justify-content-center">

            <div class="col-md-10">

                <!-- Card container that hold the information displayed on the page -->
                <div class="card">

                    <!-- Header for the card-->
                    <div class="card-header text-center">{{ __('About Us') }}</div>

                    <!-- Body of the card -->
                    <div class="card-body text-center">
                        With so many services and platforms for playing video games, it can be difficult to track
                        what games you have played on what systems. ProfileHUD aims to connect a player’s information
                        from multiple sources such as Xbox Live, PlayStation Network and Steam. The information can then
                        be presented in one easily accessible location. ProfileHUD offers a one-stop web destination
                        for tracking and viewing a player’s gaming history, providing a logbook for what games have been
                        played, which achievements have been earned, and which ones are still waiting to be completed!
                        <br/>
                        <br/>
                        Due to recent changes in PlayStation's system, integration of PlayStation Network accounts has been put on hold.
                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection

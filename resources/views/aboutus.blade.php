@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header text-center">{{ __('About Us') }}</div>

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

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('About Us') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('With so many services and platforms for playing video games, it can be difficult to get an idea of what games you have played on what systems. ProfileHUD aims to connect a player’s information from multiple sources such as Xbox Live, PlayStation Network and Steam. The information can then be presented in one easily accessible location. ProfileHUD will offer a one-stop web destination for tracking and viewing the player’s gaming history. Players will be able to use the service as a logbook for what games have been played and which achievements have been completed.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

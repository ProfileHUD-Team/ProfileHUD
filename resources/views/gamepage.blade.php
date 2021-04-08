@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-8">

                <div class="card">

                    <div class="card-header text-center">

                        Selected Game:

                    </div>

                    <div class="card-body">

                        <div class="container">

                            <div class="row">

                                <div class="col-6">

                                    <img src="{{ $game->cover_image }}" class="img-fluid" alt="Game Image"  style="height:300px; width: 200px;">

                                </div>

                                <div class="container col-6" style="padding-top: 30px">

                                    <h2>{{ $game->name }}</h2>
                                    <p>Developer: {{ $game->developer }}</p>
                                    <p>Publisher: {{ $game->publisher }}</p>
                                    <p>Release Date: {{ $game->release_date }}</p>
                                    <p>Achievements: {{ $earnedFraction }}</p>
                                    <p>Hours Played: {{ $hoursPlayed }}</p>

                                </div>

                            </div>

                        </div>

                        <div class="container text-center" style="padding-top: 30px">

                            <h2>Achievements:</h2>

                            <div style="overflow-x:auto; height: 300px">

                                <table class="table table-striped">

                                    <thead>

                                    <tr>
                                        <th>Icon</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Earned</th>
                                        <th>Date Earned</th>
                                    </tr>

                                    </thead>

                                    <tbody>

                                    @foreach($achievements as $ach)

                                        <tr>
                                            <th>
                                                <img src="{{ $ach['image'] }}" class="rounded w-75 img-fluid" alt="Achievement Icon">
                                            </th>
                                            <th>{{ $ach['name'] }}</th>
                                            <th>{{ $ach['description'] }}</th>
                                            <th>{{ $ach['pivot']['is_earned'] }}</th>
                                            <th>{{ $ach['pivot']['date_earned'] }}</th>
                                        </tr>

                                    @endforeach

                                    </tbody>

                                </table>

                            </div>

                        </div>

                        <div class="row justify-content-center align-middle" style="padding-top: 40px">

                            <button class="btn btn-primary">

                                Back

                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection

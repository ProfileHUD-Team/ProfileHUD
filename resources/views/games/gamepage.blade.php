@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{route('home')}}"> <strong><-Back</strong> </a>
        <div class="row">
            <div class="col-6">
                <img src="{{ $game->cover_image }}" class="rounded  mw-100 mh-100" style="min-width:100px ;height:300px; overflow: hidden" alt="Game Image">
            </div>
            <div class="col-6">
                <h2>{{ $game->name }}</h2>
                <p>Developer: {{ $game->developer }}</p>
                <p>Publisher: {{ $game->publisher }}</p>
                <p>Release Date: {{ $game->release_date }}</p>
                <p>Achievements: {{ $earnedFraction }}</p>
                <p>Hours Played: {{ $hoursPlayed }}</p>
            </div>
        </div>
    </div>
    <br>
    <div class="container">
        <h2>Achievements</h2>
        <table class="table table-hover">
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
                        <img src="{{ $ach['image'] }}" class="rounded w-55" style=" height:65px; overflow: hidden"alt="Achievement Icon">
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
@endsection

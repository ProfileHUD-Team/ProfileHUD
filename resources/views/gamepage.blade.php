@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <img src="{{ $game->cover_image }}" class="rounded" alt="Game Image">
            </div>
            <div class="col-sm-6">
                <h2>{{ $game->name }}</h2>
                <p>Developer: {{ $game->developer }}</p>
                <p>Publisher: {{ $game->publisher }}</p>
                <p>Release Date: {{ $game->release_date }}</p>
                <p>Achievements: {{ $earnedFraction }}</p>
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
                        <img src="{{ $ach['image'] }}" class="rounded" alt="Achievement Icon">
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

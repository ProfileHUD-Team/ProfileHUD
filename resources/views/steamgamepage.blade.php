@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <img src="{{ $game->getCoverImage() }}" class="rounded" alt="Game Image">
            </div>
            <div class="col-sm-6">
                <h2>{{ $game->getName() }}</h2>
                <p>Game ID: {{ $gameID }}</p>
                <p>Developer: {{ $game->getDeveloper() }}</p>
                <p>Publisher: {{ $game->getPublisher() }}</p>
                <p>Release Date: {{ $game->getReleaseDate() }}</p>
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
                        <img src="{{ $ach->getIconImage() }}" class="rounded" alt="Achievement Icon">
                    </th>
                    <th>{{ $ach->getName() }}</th>
                    <th>{{ $ach->getDescription() }}</th>
                    <th>{{ $ach->isEarnedStr() }}</th>
                    <th>{{ $ach->getDateEarned() }}</th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@extends('layouts.app');

@section('content')
    <div class="'container">
        <h2>Your Steam account has been linked to your ProfileHUD account.</h2>
        <p>Steam ID: {{ $steamID }} </p>
        <p>Steam Username: {{ $username }} </p>
        <p></p>
    </div>
@endsection

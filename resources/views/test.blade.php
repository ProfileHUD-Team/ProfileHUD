@extends('layouts.app')

@section('content')


    <body onload="document.game.submit()">
    <div class="container">
        <div class="container">
            <div class="h1">Getting game list from {{auth()->user()->accounts()->find($id)->platform_username}}... </div>
            <div class="h3">Please leave this page open. You will be redirected when the operation is complete.</div>
        </div>
        <p></p>
        <form name="game" id="game" action="/g" enctype="multipart/form-data" method="post">
            @csrf
            <input id="account_id"
                   type="hidden"
                   name="account_id"
                   value="{{$id}}" >
            <input id="platform_id"
                   type="hidden"
                   name="platform_id"
                   value="{{auth()->user()->accounts()->find($id)->platform_id}}" >
            <input id="platform"
                   type="hidden"
                   name="platform"
                   value="{{$platform}}" >
            <input id="games"
                   type="hidden"
                   name="games"
                   value="{{serialize( get_defined_vars()['games']) }}" >
        </form>
    </div>
    </body>
@endsection

@extends('layouts.app');

@section('content')

    <body onload="document.achievements.submit()">
    <div class="container">
        <div class="container">
            <div class="h1">Getting achievements from {{auth()->user()->accounts()->find($id)->platform_username}}... </div>
            <div class="h3">Please leave this page open. You will be redirected when the operation is complete.</div>
        </div>
        <p></p>
        <form name="achievements" id="achievements" action="/ach" enctype="multipart/form-data" method="post">
            @csrf
            <input id="account_id"
                   type="hidden"
                   name="account_id"
                   value="{{$id}}" >
            <input id="platform"
                   type="hidden"
                   name="platform"
                   value="{{$platform}}" >
            <input id="games"
                   type="hidden"
                   name="games"
                   value="{{serialize( get_defined_vars()['games']) }}" >
        </form>
    </div>
    </body>
@endsection

@section('content')
    <!-- This page converts the GET to a POST and posts the info to Accounts-->
    <body onload="document.account.submit()">
    <div class="container">
        <h2>Linking Steam account <strong>{{$username}}</strong>....</h2>
        <p></p>
        <form name="account" id="account" action="/a" enctype="multipart/form-data" method="post">
            @csrf
            <input id="platform"
                   type="hidden"
                   name="platform"
                   value="stm" >
            <input id="platform_username"
                   type="hidden"
                   name="platform_username"
                   value="{{ $username }}" >
            <input id="platform_id"
                   type="hidden"
                   name="platform_id"
                   value="{{ $steamID }}" >
            <input id="profile_image"
                   type="hidden"
                   name="profile_image"
                   value="{{"$profileImage"}}" >
        </form>
    </div>
    </body>


@endsection

@extends('layouts.app')

@section('content')
    <!-- This page converts the GET to a POST and posts the info to Accounts-->
    <body onload="document.account.submit()">
    <div class="container">
        <h2>Linking account <strong>{{$platform_username}}</strong>....</h2>
        <p></p>
        <form name="account" id="account" action="/a" enctype="multipart/form-data" method="post">
            @csrf
            <input id="platform"
                   type="hidden"
                   name="platform"
                   value="{{$platform}}" >
            <input id="platform_username"
                   type="hidden"
                   name="platform_username"
                   value="{{ $platform_username }}" >
            <input id="platform_id"
                   type="hidden"
                   name="platform_id"
                   value="{{ $platform_id }}" >
            <input id="profile_image"
                   type="hidden"
                   name="profile_image"
                   value="{{$profile_image}}" >
        </form>
    </div>
    </body>


@endsection

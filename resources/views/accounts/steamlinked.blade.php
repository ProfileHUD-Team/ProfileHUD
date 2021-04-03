@extends('layouts.app')

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
        </form>
    </div>
    </body>


@endsection

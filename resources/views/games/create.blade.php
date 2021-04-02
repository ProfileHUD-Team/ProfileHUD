@extends('layouts.app');

@section('content')


    <body onload="document.game.submit()">
    <div class="container">
        <div class="container">
            <div class="h1">Getting game list from {{auth()->user()->accounts()->find($id)->platform_username}}... </div>
            <div class="h3">Please leave this page open. You will be redirected when the operation is complete.</div>
            <div><?php print_r(get_defined_vars()['games'])?></div>
        </div>
        <p></p>
        <form name="game" id="game" action="/g" enctype="multipart/form-data" method="post">
            @csrf
            <input id="id"
                    type="hidden"
                    name="id"
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

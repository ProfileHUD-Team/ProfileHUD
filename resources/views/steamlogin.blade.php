@extends('layouts.app');

@section('content')
    <div class="'container">
        <h1>Link your Steam Account to ProfileHUD</h1>
        <p>This page will help you link your Steam account to ProfileHUD. When you click the button below,
        you will be redirected to Steam to sign in. When you do, you will be redirected back to ProfileHUD
        and your Steam account will be successfully linked.</p>
        <br>
        <form action='steamredirect'>
            <input type="image" src="https://community.cloudflare.steamstatic.com/public/images/signinthroughsteam/sits_02.png" alt="">
        </form>
    </div>
@endsection

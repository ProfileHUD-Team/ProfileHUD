<!--
    This page serves a message to the user to wait while their games are added to the database. It only passes information through.
    edited: Eric, Greg
    package: resources/views/games
-->

<!-- Inherits layout page -->
@extends('layouts.app')

<!-- Content of this view page begins -->
@section('content')

    <body onload="document.game.submit()">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-md-8">

                    <!-- Card container -->
                    <div class="card">

                        <!-- Card header -->
                        <div class="card-header text-center">

                            <strong>Please Wait</strong>

                        </div>

                        <!-- Card body -->
                        <div class="card-body text-center">

                            <p>Getting game list from {{auth()->user()->accounts()->find($id)->platform_username}}...</p>
                            <p>Do not leave or close this page, you will be redirected when the operation is complete.</p>

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

                    </div>

                </div>

            </div>

        </div>

    </body>

@endsection


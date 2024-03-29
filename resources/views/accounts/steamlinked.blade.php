<!--
    This page serves a message to the user to wait while their account is added to the database.
    It only passes information through.
    edited: Eric, Greg
    package: resources/views/accounts
-->

<!-- Inherits layouts page-->
@extends('layouts.app')

<!-- Section of code where content begins-->
@section('content')

    <body onload="document.account.submit()">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-8">

                <!-- Card container -->
                <div class="card">

                    <!-- Card header-->
                    <div class="card-header text-center">

                        <strong>Please Wait</strong>

                    </div>

                    <!-- Card body -->
                    <div class="card-body text-center">

                        <p>Linking Steam account {{$username}}...</p>

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

                </div>

            </div>

        </div>

    </div>

    </body>

@endsection

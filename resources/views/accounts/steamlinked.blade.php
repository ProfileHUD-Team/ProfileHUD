@extends('layouts.app')

@section('content')

    <body onload="document.account.submit()">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-8">

                <div class="card">

                    <div class="card-header text-center">

                        Please Wait

                    </div>

                    <div class="card-body text-center">

                        Linking Steam account name {{$username}}.

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

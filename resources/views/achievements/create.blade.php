<!--
    This page serves a message to the user to wait while their achievements are added to the database.
    It only passes information through.
    edited: Eric, Gregory
    package: resources/views/achievements

-->

<!-- Inheritance of layouts page-->
@extends('layouts.app')

<!-- Section where websites content begins-->
@section('content')

    <body onload="document.achievements.submit()">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-md-8">

                    <!-- Card container-->
                    <div class="card">

                        <!-- Card Header-->
                        <div class="card-header text-center">

                           <strong>Please Wait</strong>

                        </div>

                        <!-- Card Body -->
                        <div class="card-body text-center">

                            <p>Getting achievements for {{auth()->user()->accounts()->find($id)->platform_username}}...</p>
                            <p>Do not leave or close this page, you will be redirected when the operation is complete.</p>

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

                    </div>

                </div>

            </div>

        </div>

    </body>

@endsection

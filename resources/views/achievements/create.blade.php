@extends('layouts.app')

@section('content')

    <body onload="document.achievements.submit()">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-md-8">

                    <div class="card">

                        <div class="card-header text-center">

                            Please Wait

                        </div>

                        <div class="card-body text-center">

                            Getting achievements from {{auth()->user()->accounts()->find($id)->platform_username}}.
                            Do not leave this page open, you will be redirected when the operation is complete.

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

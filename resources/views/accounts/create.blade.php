@extends('layouts.app')

<!-- This page serves a a form to the user, displaying and hiding buttons as necessary for adding/updating accounts. -->
@section('content')

    <div class="container">
        <a href="{{route('home')}}"> <strong><-Back</strong> </a>
        <div class="row justify-content-center">

            <div class="col-md-8">

                <div class="card">

                    <div class="card-header text-center">
                        <strong>Add or Update Profile</strong>
                    </div>

                    <div class="card-body">
                        <form {{$addxbl}} action="/a/profile" enctype="multipart/form-data" method="post">
                            @csrf

                            <div class="form-group row">

                                <label for="platform_username" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Account Name') }}
                                </label>

                                <div class="col-md-6">
                                    <input id="platform_username"
                                           type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           name="platform_username"
                                           value="{{ old('name') }}" required autofocus>

                                    @error('platform_username')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">

                                <label for="platform" class="col-md-4 col-form-label text-md-right">
                                    Platform
                                </label>

                                <label class="radio-inline" style="padding-top: 10px; padding-left: 15px">
                                    <input type="radio" id="platform" name="platform" value="xbl" checked>
                                    Xbox
                                </label>

                                <label class="radio-inline" style="padding-top: 10px; padding-left: 15px">
                                    <input type="radio" id="platform" name="platform" value="psn" disabled>
                                    PlayStation
                                </label>

                            </div>

                            <div class="text-center">
                                    <button type="submit" class="btn btn-primary">
                                        Link Profile
                                    </button>

                            </div>
                        </form>

                        <form {{$updatexbl}} action="/a/update" enctype="multipart/form-data" method="post">
                            @csrf
                            <input type="hidden" id="platform" name="platform" value="xbl">
                            <input type="hidden" id="id" name="id" value="{{$xblAcc}}">
                                <div class="text-center">

                                    <button type="submit" class="btn btn-primary">
                                        Update Xbox Profile
                                    </button>

                                </div>
                        </form>

                        <div class="text-center pt-4" >

                            <form {{$addstm}} action='steamredirect' method='get'>
                                <input type="image" src="https://community.cloudflare.steamstatic.com/public/images/signinthroughsteam/sits_02.png">
                            </form>

                            <form {{$updatestm}} action="/a/update" enctype="multipart/form-data" method="post">
                                @csrf
                                <input type="hidden" id="platform" name="platform" value="stm">
                                <input type="hidden" id="id" name="id" value="{{$stmAcc}}">
                                    <div class="text-center">

                                        <button type="submit" class="btn btn-primary">
                                            Update Steam Profile
                                        </button>

                                    </div>
                            </form>

                        </div>
                        <div class="text-center pt-3">
                            <i><small>Please ensure Game Details is marked Public in your <a href="https://support.steampowered.com/kb_article.php?ref=4113-YUDH-6401">Steam Profile Privacy Settings</a>.<br/>
                                No information will be found if your settings are set to Private or Friends Only.</small></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-8">

                <div class="card">

                    <div class="card-header">
                        Add Profile Account
                    </div>

                    <div class="card-body">
                        <form action="/a/profile" enctype="multipart/form-data" method="post">
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

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">

                                    <button type="submit" class="btn btn-primary">
                                        Link Account
                                    </button>

                                </div>
                            </div>
                        </form>

                        <div class="offset-md-4" style="padding-top: 25px; padding-left: 10px">

                            <form action='steamredirect' method='get'>
                                <input type="image" src="https://community.cloudflare.steamstatic.com/public/images/signinthroughsteam/sits_02.png">
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

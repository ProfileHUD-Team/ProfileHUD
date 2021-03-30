@extends('layouts.app');

@section('content')
    <div class="container">
        <form action="/a" enctype="multipart/form-data" method="post">
            @csrf
            <div class="row">
                <div class="col-4 offset-1">
                    <div class="row">
                        <div class="h2">Add an Account</div>
                    </div>
                    <div class="row pt-4 pl-4">
                        <label for="platform" class="col-md-4 col-form-label text-md-center"> Platform </label>
                        <select id="platform" name="platform">
                            <option disabled selected value>Select A Platform</option>
                            <option hidden value="stm">Steam</option>
                            <option value="xbl">Xbox</option>
                            <option value="psn">PlayStation</option>
                        </select>
                    </div>

                    <div class="row pt-4">
                        <label for="platform_username" class="col-md-4 col-form-label text-md-right">{{ __('Account Name') }}</label>

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

                    <div class="row pt-3 pl-2 offset-4">
                        <button class="btn btn-primary">Link Account</button>
                    </div>

                    <div class="h5 pt-4 offset-2"> <b>OR</b> <a href="">Sign in with Steam</a></div>
                </div>
            </div>
        </form>
    </div>
@endsection
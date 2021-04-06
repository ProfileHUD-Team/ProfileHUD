@extends('layouts.app')

@section('content')
    <div class="container flex">

        <div class="row justify-content-center align-middle">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">Add a Profile Account</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="/a" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-4 offset-1">

                                    <div class="row">
                                        <div class="h2">Add an Account</div>
                                    </div>

                                    <div class="row pt-4">
                                        <label for="platform" class="col-md-4">
                                            Platform
                                        </label>
                                        <select id="platform" name="platform">
                                            <option disabled selected value>
                                                Select A Platform
                                            </option>
                                            <option hidden value="stm">
                                                Steam
                                            </option>
                                            <option value="xbl">
                                                Xbox
                                            </option>
                                            <option disabled value="psn">
                                                PlayStation
                                            </option>
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
                                        <button class="btn btn-primary" class="row justify-content-center align-middle">
                                            Link Account
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="h5 pt-4 offset-2">
                            <b>
                                OR
                            </b>
                            <form class="pt-4" action='steamredirect' method='get'>
                                <input type="image" src="https://community.cloudflare.steamstatic.com/public/images/signinthroughsteam/sits_02.png" alt="">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
@endsection

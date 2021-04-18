@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{route('home')}}"> <strong><-Back</strong> </a>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Remove Profiles or Delete Account</div>

                    <div class="card-body">
                        <form {{$hasXbl}} method="POST" action="{{ route('removeAcc') }}">
                            @csrf
                            <input type="hidden" id="platform" name="platform" value="xbl">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary"
                                        onclick="return confirm('Continuing will remove your Xbox information from your account and our servers.');">
                                    Remove Xbox Profile
                                </button>
                            </div>
                        </form>
                        <form {{$hasStm}} method="POST" action="{{ route('removeAcc') }}">
                            @csrf
                            <input type="hidden" id="platform" name="platform" value="stm">
                            <div class="text-center pt-4">
                                <button type="submit" class="btn btn-primary"
                                        onclick="return confirm('Continuing will remove your Steam information from your account and our servers.');">
                                    Remove Steam Profile
                                </button>
                            </div>
                        </form>
                        <form method="POST" action="{{ route('deleteuser') }}">
                            @csrf
                            <div class="text-center pt-4">
                                <button type="submit" class="btn btn-primary" style="background-color: darkred"
                                        onclick="return confirm('Continuing will permanently erase your ProfileHUD account.');">
                                    Delete ProfileHUD Account
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

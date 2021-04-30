<!--
    This page gives the authenticated user the ability to remove their accounts and delete their entire user.
    edited: Eric, Gregory
    package: /resources/views
-->

<!-- Inheritance of the layouts page -->
@extends('layouts.app')

<!-- Section of code where the content of this website begins -->
@section('content')

    <!-- Container for the content of the website -->
    <div class="container">

        <!-- Back button that returns to the previous page -->
        <a href="{{route('home')}}"> <strong><-Back</strong> </a>

        <div class="row justify-content-center">

            <div class="col-md-8">

                <!-- Card container that displays the websites content -->
                <div class="card">

                    <!-- Card header -->
                    <div class="card-header">Remove Profiles or Delete Account</div>

                    <!-- Card body -->
                    <div class="card-body">

                        <!-- The following two forms will appear/hide based on information from the Accounts controller.
                        If there is a steam or xbox account tied to the authenticated user, a Remove button will appear. -->
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

                        <!-- This button will remove the user from the database along with all of their information. -->
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

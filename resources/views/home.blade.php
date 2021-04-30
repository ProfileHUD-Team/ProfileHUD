<!--
    This page is the main page of the website which corresponds to the profile page as well as the home page.
    edited: Eric
    package: /resources/views
-->

<!-- Inheritance of the layout page-->
@extends('layouts.app')

<!-- Scripts -->
<script src="/js/accordion.js" defer></script>

<!-- Styles -->
<link href="/css/accordion.css" rel="stylesheet">

<!-- Sectiono the layouts page were the content begins for this view page-->
@section('content')

    <div class="container flex">

        <div class="row justify-content-center align-middle">

            <div class="col-md-10">

                <!-- Card container to display view page content-->
                <div class="card">

                    <!-- Card header -->
                    <div class="card-header text-center">

                        <strong>Gaming Profiles</strong>

                    </div>

                    <!-- Card body-->
                    <div class="card-body">

                        <!-- Check to make sure that user has a profile-->
                        @if (session('status'))

                            <div class="alert alert-success" role="alert">

                                {{ session('status') }}

                            </div>

                        @endif

                        <!-- Accordion dropdown menu-->
                        <button class="accordion d-flex justify-content-between" >

                            <!-- Display the number of achievements obtained -->
                            <div> <strong>Steam</strong> </div><div>Achievements: {{$stmCounts['total']}}</div>

                        </button>

                            <div class="panel">

                                <div style="overflow-x:auto; height: 400px">

                                    <!-- Table to display steam information-->
                                    <table class="table table-striped">

                                        <!-- Table head-->
                                        <thead>

                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Achievements</th>
                                                <th scope="col">Developer</th>
                                            </tr>

                                        </thead>

                                        <!-- Table body-->
                                        <tbody>

                                            <!-- Loop to populate table-->
                                            @foreach($stm as $game)

                                                <tr>
                                                    <th>
                                                        <a href="{{route('gamepage',$game['id'])}}">
                                                            <img src="{{$game['cover_image']}}" class="rounded  mw-100 mh-100" style="min-width:100px; width:150px; overflow: hidden" alt="Game Image">
                                                        </a>
                                                    </th>
                                                    <th>
                                                        <a href="{{route('gamepage',$game['id'])}}">
                                                            {{ $game['name']}}
                                                        </a>
                                                    </th>
                                                    <th>{{ $stmCounts[$game['id']] }}</th>
                                                    <th>{{ $game['developer'] }}</th>

                                                </tr>

                                            @endforeach

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                    <!-- Second accordion menu option-->
                    <button class="accordion d-flex justify-content-between">

                        <div><strong>Xbox</strong></div> <div>Achievements: {{$xblCounts['total']}}</div>

                    </button>

                    <div class="panel">

                        <div style="overflow-x:auto; height: 400px">

                            <!-- Table to display Xbox information-->
                            <table class="table table-striped">

                                <!-- Table head -->
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Achievements</th>
                                        <th scope="col">Developer</th>
                                    </tr>
                                </thead>

                                <!-- Table body-->
                                <tbody>

                                    <!-- Loop to populate table -->
                                    @foreach($xbl as $game)

                                        <tr>
                                            <th>
                                                <a href="{{route('gamepage',$game['id'])}}">
                                                    <img src="{{$game['cover_image']}}" class="rounded  mw-100 mh-100" style=" min-width: 65px;height:90px; overflow: hidden" alt="Game Image">
                                                </a>
                                            </th>
                                            <th>
                                                <a href="{{route('gamepage',$game['id'])}}">
                                                    {{ $game['name']}}
                                                </a>
                                            </th>
                                            <th>{{ $xblCounts[$game['id']] }}</th>
                                            <th>{{ $game['developer'] }}</th>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>

                        <!-- Button that adds or updates profile-->
                        <div class="row justify-content-center align-middle" style="padding-top: 40px">

                            <form action="a/create">

                                <button class="btn btn-primary">

                                    Add or Update Profile

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection

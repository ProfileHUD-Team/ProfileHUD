
@extends('layouts.app')

<!-- Scripts -->
<script src="/js/accordion.js" defer></script>

<!-- Styles -->
<link href="/css/accordion.css" rel="stylesheet">

@section('content')

    <div class="container flex">

        <div class="row justify-content-center align-middle">

            <div class="col-md-8">

                <div class="card">

                    <div class="card-header text-center">

                        Gaming Profiles

                    </div>

                    <div class="card-body">

                        @if (session('status'))

                            <div class="alert alert-success" role="alert">

                                {{ session('status') }}

                            </div>

                        @endif

                        <button class="accordion">Steam</button>

                            <div class="panel">

                                <div style="padding-top: 5px; padding-bottom: 5px">

                                    <div style="font-size: large">

                                        Games:

                                    </div>

                                <div style="overflow-x:auto; height: 243px">

                                    <table class="table table-striped">

                                        <thead>

                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Developer</th>
                                                <th scope="col">Achievements</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            @foreach($stm as $game)

                                                <tr>

                                                    <th>
                                                        <a href="">
                                                            {{ $game['id']}}
                                                        </a>
                                                    </th>
                                                    <th>{{ $game['name'] }}</th>
                                                    <th>{{ $game['developer'] }}</th>
                                                    <th>{{ $game['has_achievements'] }}</th>

                                                </tr>

                                            @endforeach

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    <button class="accordion">
                        Xbox
                    </button>

                    <div class="panel">

                        <div style="padding-top: 5px; padding-bottom: 5px">

                            <div style="font-size: large">
                                Games:
                            </div>

                            <div style="overflow-x:auto; height: 243px">

                                <table class="table table-striped">

                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Developer</th>
                                            <th scope="col">Achievements</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach($xbl as $game)

                                            <tr>

                                                <th>
                                                    <a href="">
                                                        {{ $game['id']}}
                                                    </a>
                                                </th>
                                                <th>{{ $game['name'] }}</th>
                                                <th>{{ $game['developer'] }}</th>
                                                <th>{{ $game['has_achievements'] }}</th>

                                            </tr>

                                        @endforeach

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>
                        <div class="row justify-content-center align-middle" style="padding-top: 40px">

                            <form action="a/create">

                                <button class="btn btn-primary">

                                    Add Profile

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection

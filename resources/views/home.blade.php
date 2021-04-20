
@extends('layouts.app')

<!-- Scripts -->
<script src="/js/accordion.js" defer></script>

<!-- Styles -->
<link href="/css/accordion.css" rel="stylesheet">

@section('content')

    <div class="container flex">

        <div class="row justify-content-center align-middle">

            <div class="col-md-10">

                <div class="card">

                    <div class="card-header text-center">

                        <strong>Gaming Profiles</strong>

                    </div>

                    <div class="card-body">

                        @if (session('status'))

                            <div class="alert alert-success" role="alert">

                                {{ session('status') }}

                            </div>

                        @endif

                        <button class="accordion d-flex justify-content-between" >
                            <div> <strong>Steam</strong> </div><div>Achievements: {{$stmCounts['total']}}</div>
                        </button>

                            <div class="panel">

                                <div style="overflow-x:auto; height: 400px">

                                    <table class="table table-striped">

                                        <thead>

                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Achievements</th>
                                                <th scope="col">Developer</th>
                                            </tr>

                                        </thead>

                                        <tbody>

                                            @foreach($stm as $game)

                                                <tr>
                                                    <th><img src="{{$game['cover_image']}}" class="rounded  mw-100 mh-100" style="height:70px; overflow: hidden" alt="Game Image"></th>
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

                    <button class="accordion d-flex justify-content-between">
                        <div><strong>Xbox</strong></div> <div>Achievements: {{$xblCounts['total']}}</div>
                    </button>

                    <div class="panel">

                        <div style="overflow-x:auto; height: 400px">

                            <table class="table table-striped">

                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Achievements</th>
                                        <th scope="col">Developer</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach($xbl as $game)

                                        <tr>
                                            <th><img src="{{$game['cover_image']}}" class="rounded  mw-100 mh-100" style="height:100px; overflow: hidden" alt="Game Image"></th>
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


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

                        Gaming Profiles

                    </div>

                    <div class="card-body">

                        @if (session('status'))

                            <div class="alert alert-success" role="alert">

                                {{ session('status') }}

                            </div>

                        @endif

                        <button class="accordion d-flex justify-content-between" >

                            <div>

                                Steam

                            </div>

                            <div>

                                Achievements: {{$stmCounts['total']}}

                            </div>

                        </button>

                            <div class="panel">

                                <div style="overflow-x:auto; height: 400px">

                                    <table class="table table-striped">

                                        <thead>

                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Achievements</th>
                                                <th scope="col">Developer</th>
                                            </tr>

                                        </thead>

                                        <tbody>

                                            @foreach($stm as $game)

                                                <tr>

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
                        <div>Xbox</div>
                        <div> Achievements: {{$xblCounts['total']}}</div>
                    </button>

                    <div class="panel">

                        <div style="overflow-x:auto; height: 400px">

                            <table class="table table-striped">

                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Achievements</th>
                                        <th scope="col">Developer</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach($xbl as $game)

                                        <tr>

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

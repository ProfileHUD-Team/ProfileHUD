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
                <div class="card-header text-center">Gaming Profiles</div>
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

                                < style="overflow-x:auto; height: 243px">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">First</th>
                                            <th scope="col">Last</th>
                                            <th scope="col">Handle</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr>
                                            <th scope="row">1</th>
                                            <td>Mark</td>
                                            <td>Otto</td>
                                            <td>@mdo</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td>Jacob</td>
                                            <td>Thornton</td>
                                            <td>@fat</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td>Larry</td>
                                            <td>the Bird</td>
                                            <td>@twitter</td>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>Mark</td>
                                            <td>Otto</td>
                                            <td>@mdo</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td>Jacob</td>
                                            <td>Thornton</td>
                                            <td>@fat</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td>Larry</td>
                                            <td>the Bird</td>
                                            <td>@twitter</td>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>Mark</td>
                                            <td>Otto</td>
                                            <td>@mdo</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td>Jacob</td>
                                            <td>Thornton</td>
                                            <td>@fat</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td>Larry</td>
                                            <td>the Bird</td>
                                            <td>@twitter</td>
                                        </tr>
=======

                                            @foreach($stm as $game)

                                                <tr>

                                                    <th>
                                                        <a href="{{route('gamepage',$game['id'])}}">
                                                            {{ $game['name']}}
                                                        </a>
                                                    </th>
                                                    <div>
                                                        <img src="{{ $game->cover_image }}" class="rounded  w-100 mh-100" alt="Game Image">
                                                    </div>>
                                                    <th>{{ $stmCounts[$game['id']] }}</th>
                                                    <th>{{ $game['developer'] }}</th>

                                                </tr>

                                            @endforeach

>>>>>>> Stashed changes
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    <button class="accordion">Xbox</button>
                    <div class="panel">
<<<<<<< Updated upstream
                        <div style="padding-top: 5px; padding-bottom: 5px">
                            In Progress...
=======

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

                                            <div>
                                                <img src="{{ $game->cover_image }}" class="rounded  w-100 mh-100" alt="Game Image">
                                            </div>
                                            <th>{{ $xblCounts[$game['id']] }}</th>
                                            <th>{{ $game['developer'] }}</th>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

>>>>>>> Stashed changes
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

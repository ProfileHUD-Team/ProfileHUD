@extends('layouts.app')

<!-- Scripts -->
<script src="/js/accordion.js" defer></script>

<!-- Styles -->
<link href="/css/accordion.css" rel="stylesheet">

@section('content')

    <div class="container">
        <div class="row justify-content-center align-middle"">
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
                            <div class="text-center">
                                <form action='steamredirect'>
                                    <input type="image" src="https://community.cloudflare.steamstatic.com/public/images/signinthroughsteam/sits_02.png" style ="height: 100px; width: 150px">
                                </form>
                            </div>
                        </div>
                    </div>
                    <button class="accordion">Xbox</button>
                    <div class="panel">
                        <div style="padding-top: 5px; padding-bottom: 5px">
                            In Progress...
                        </div>
                    </div>
                    <button class="accordion">PlayStation</button>
                    <div class="panel">
                        <div style="padding-top: 5px; padding-bottom: 5px">
                            In Progress...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

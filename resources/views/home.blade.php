@extends('layouts.app')

<!-- Scripts -->
<script src="/js/accordion.js" defer></script>

<!-- Styles -->
<link href="/css/accordion.css" rel="stylesheet">

@section('content')

    <div class="container flex">

        <div class="row justify-content-center align-middle">
            <div class="col-md-2 pt-1">
                <form action="a/create">
                    <button class="btn btn-primary" >Add Profile</button>
                </form>
            </div>
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
                                In Progress...
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

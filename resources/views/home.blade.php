@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="d-flex">
            <div class="col-3">
                <h2>3 columns here</h2>
            </div>
            <div class="col-9">
                <h2>9 columns here</h2>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <h1>Testing columns</h1>
    <div class="row">
        <div class="col-sm-4" style="background-color:lavender;">.col-sm-4</div>
        <div class="col-sm-4" style="background-color:lavenderblush;">.col-sm-4</div>
        <div class="col-sm-4" style="background-color:lavender;">.col-sm-4</div>
    </div>
</div>
@endsection

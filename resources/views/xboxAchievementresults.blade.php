<h1>Xbox api test</h1>




@foreach ($response as $data)


    <h3> Game name : {{$data['name'] }} </h3>
    <img src= {{$data['displayImage'] }} >  <br>
    <h5>Game Id : {{$data['titleId']}} <br></h5>
    <h5>Type: {{$data['type']}} <br></h5>





@endforeach

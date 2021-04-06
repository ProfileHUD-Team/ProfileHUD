<head></head>
<body>
@foreach ($response as $data)


    <div>
        <img src={{$data['displayImage'] }} style="width:128px;height:128px" alt="icon">
        <br>
        Current Achievements: {{$data['achievement']['currentAchievements']}}
        <br>
        Total Achievements: {{$data['achievement']['totalAchievements']}}
        <br>
        Current Gamerscore: {{$data['achievement']['currentGamerscore']}}
        <br>
        Total Gamerscore :{{$data['achievement']['totalGamerscore']}}
        <br>
        Progress Percentage: {{$data['achievement']['progressPercentage']}}
    </div>



@endforeach


<div style="text-align: center;">

    <style>
        div {

            border: 1px;
            display: flex;


        }

        button {

            cursor: hand;

            font-size: 10px;
            border: 2px solid #222;
            color: black;
            text-transform: uppercase;
            font-weight: 600;
            background: #fff;
        }


    </style>


</div>

</body>


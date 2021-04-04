<head></head>
<body>

@foreach ($response as $data)
    Game Name: {{$data['name']}}
    <br>
    Earned Achievements: {{$data['earnedAchievements'] }}
    <br>
    Current Gamer score: {{$data['currentGamerscore'] }}
    <br>
    MaxGamer Score: {{$data['maxGamerscore'] }}T
@endforeach
</body>

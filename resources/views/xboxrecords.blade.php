<head></head>
<body>

@foreach ($response as $data)
    Game Name: {{$data['name']}}
    <br>
    Earned Achievements: {{$data['earnedAchievements'] }}
    <br>
    Current score: {{$data['currentGamerscore'] }}
    <br>
    MaxGamer Score: {{$data['maxGamerscore'] }}
@endforeach
</body>

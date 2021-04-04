<head></head>
<body>
@foreach ($response as $data)



    <div class="container">
        <div class="center">

            <img src={{$data['displayPicRaw'] }} style="width:128px;height:128px" alt="icon">
            <br>
            User ID: {{$data['xuid'] }}
            <br>
            Display Name: {{$data['displayName'] }}
            <br>
            Gamer Tag: {{$data['gamertag'] }}
            <br>
            Player Score: {{$data['gamerScore'] }}
            <br>
            Xbox One Rep: {{$data['xboxOneRep'] }}
            <br>
            Player State: {{$data['presenceState'] }}
            <br>
            Last time online : {{$data['presenceText'] }}
            <br>


            @endforeach
        </div>
    </div>


            <form action="userprofile" method="GET">


                <br>
                <input type="hidden" value="{{$data['xuid'] }}" name="achievements">
                <button type="submit" onclick="submit_soap()">View Games</button>

            </form>

    <br>
    <div id="json_response"></div>

    <script>
        alert('your account is successfully Linked')

        function submit_soap() {
            var achievements = $("#achievements").val();
            $.get("userprofile", {achievements: achievements},
                function (data) {
                    $("#json_response").html(data);
                });
        }
    </script>

    <style>

        .container {
            height: 200px;
            position: relative;


        }

        .center {
            margin: 0;
            position: absolute;
            top: 100%;
            left: 40%;
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
        }
        button {
            cursor:hand;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 15px;
            font-size: 18px;
            border: 2px solid #222;
            color: black;
            text-transform: uppercase;
            font-weight: 600;
            background: #fff;
        }
    </style>


</body>

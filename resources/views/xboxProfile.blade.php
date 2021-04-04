@foreach ($response as $data)



    <div class="container">
        <div class="center">

            <img src={{$data['displayPicRaw'] }} style="width:128px;height:128px" alt="icon">
            <br>
            User ID: {{$data['xuid'] }}
            <br>
            Display Name: {{$data['displayName'] }}
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


                <form action="userprofile" method="GET">


                <label>
                    <br>
                    To view Games:  <input type="text" placeholder="Enter User ID Here" name="achievements">
                </label>
                <button type="submit" onclick="submit_soap()">View Games</button>

            </form>
        </div>
    </div>
    <br>
    <div id="json_response"></div>

    <script>

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
    </style>



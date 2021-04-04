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
<div class="container">
    <div class="center">
        <h1>Getting Profile...</h1>


        <form action="xboxprofile" method="GET">


            <br>
            <input type="hidden" name="profile" value="{{$user}}">
            <button id="submit" onclick="submit_soap()"></button>

        </form>

        <script>
            document.getElementById("submit").click();


            function submit_soap() {
                var profile = $("#profile").val();
                $.get("xboxprofile", {profile: profile},
                    function (data) {
                        $("#json_response").html(data);
                    });
            }
        </script>

    </div>
</div>
<br>
<div id="json_response"></div>


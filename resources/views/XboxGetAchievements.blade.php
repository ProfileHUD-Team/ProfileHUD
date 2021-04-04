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

        <p id="id">{{'User Id is: '.$user}}</p>


        <script>

            function submit_soap() {
                var profile = $("#profile").val();
                $.get("xboxprofile", {profile: profile},
                    function (data) {
                        $("#json_response").html(data);
                    });
            }
        </script>

        <form action="xboxprofile" method="GET">


            Enter Your User ID To Finish linking Your Account
            <br>
            <input type="text" name="profile" placeholder="Enter User ID Here">
            <button type="submit" onclick="submit_soap()">Link</button>

        </form>
    </div>
</div>
<br>
<div id="json_response"></div>


<head>
</head>

<body>
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
        position: absolute;
        top: 70%;
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

<div class="container">
    <div class="center">


        <form action="xboxprofile" method="GET">


            <input type="hidden" name="profile" value="{{$user}}">
            <button id="submit" onclick="submit_soap()">linking Account...</button>

        </form>
    </div>
</div>

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


<br>
<div id="json_response"></div>


</body>

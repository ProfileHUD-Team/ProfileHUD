<head></head>
<body>


<script src="https://kit.fontawesome.com/38c1929a11.js" crossorigin="anonymous"></script>


<div class="container">
    <div class="center">


        <button
            class="open-button" onclick="togglePopup()"
            type="submit">Link Xbox Account<i class='fab fa-xbox' style='font-size:50px;color:green'></i></button>
    </div>
</div>


<div class="popup" id="popup-1">
    <div class="overlay"></div>
    <div class="content">
        <div class="close-btn" onclick="togglePopup()">&times;</div>


        <form action="xboxid" method="GET">

            <h1>Enter Xbox Gamer Tag</h1>
            <input type="text" name="userid" placeholder="Enter Gamer Tag Here"><br><br>
            <button type="submit" onclick="userid()">link</button>

        </form>

        <br>
        <div id="json_response"></div>

    </div>
</div>


<script>
    function togglePopup() {
        document.getElementById("popup-1").classList.toggle("active");
    }

    function togglePopup2() {
        document.getElementById("popup-1").classList.toggle("active");
    }

    function userid() {
        var gamertag = $("#userid").val();
        $.get("gamertag", {gamertag: gamertag},
            function (data) {
                $("#json_response").html(data);
            });
    }


    function submit_soap() {
        var gamertag = $("#userid").val();
        $.get("gamertag", {gamertag: gamertag},
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

    .popup .overlay {
        position: fixed;
        top: 0px;
        left: 0px;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.7);
        z-index: 1;
        display: none;
    }

    .popup .content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0);
        background: #fff;
        width: 500px;
        height: 250px;
        z-index: 2;
        text-align: center;
        padding: 20px;
        box-sizing: border-box;
        font-family: "Open Sans", sans-serif;
    }

    .popup .close-btn {
        cursor: pointer;
        position: absolute;
        right: 20px;
        top: 20px;
        width: 30px;
        height: 30px;
        background: #222;
        color: #fff;
        font-size: 25px;
        font-weight: 600;
        line-height: 30px;
        text-align: center;
        border-radius: 50%;
    }

    .popup.active .overlay {
        display: block;
    }

    .popup.active .content {
        transition: all 300ms ease-in-out;
        transform: translate(-50%, -50%) scale(1);
    }


    button {
        cursor: hand;
        position: absolute;
        top: 70%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 15px;
        font-size: 18px;
        border: 2px solid #222;
        color: #222;
        text-transform: uppercase;
        font-weight: 600;
        background: #fff;
    }


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


</body>













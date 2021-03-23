<h1>Get user ID</h1>


<script>
    function submit_soap() {
        var gamertag = $("#userid").val();
        $.get("gamertag", {gamertag: gamertag},
            function (data) {
                $("#json_response").html(data);
            });
    }
</script>

<form action="gamertag" method="GET">
    <input type="text" name="userid" placeholder="enter gamer tag here"><br><br>
    <button type="submit" onclick="submit_soap()">Get xuid</button>
</form>
<br>
<div id="json_response"></div>







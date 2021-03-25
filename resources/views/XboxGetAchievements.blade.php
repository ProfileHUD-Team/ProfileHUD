<h1>Get Achievements</h1>


<p id="id">{{'User Id is:'.$user}}</p>


<script>

    function submit_soap() {
        var achievements = $("#achievements").val();
        $.get("xboxprofile", {achievements: achievements},
            function (data) {
                $("#json_response").html(data);
            });
    }
</script>

<form action="xboxprofile" method="GET">
    <input type="text" name="achievements" placeholder="enter id here"><br><br>
    <button type="submit" onclick="submit_soap()">Get achievements</button>
</form>
<br>
<div id="json_response"></div>


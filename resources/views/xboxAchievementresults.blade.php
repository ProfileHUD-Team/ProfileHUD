@foreach ($response as $data)


    <div>

        <img src={{$data['displayImage'] }} style="width:128px;height:128px" alt="icon">
        <br>
        <form action="playerrecord" method="GET">
            <input type="hidden" name="records" value="{{$data['titleId']}}">
            <button type="submit" onclick="submit_soap()">Game Stats</button>
        </form>
    </div>



@endforeach





<div style="text-align: center;">
    <script>
        function submit_soap() {
            var records = $("#records").val();
            $.get("playerrecord", {records: records},
                function (data) {
                    $("#json_response").html(data);
                });
        }


    </script>
    <style>
        div {

            border: 1px;
            display: inline-block;


        }


    </style>


</div>


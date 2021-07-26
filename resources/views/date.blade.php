@extends('layouts.app')


@section('content')
<head>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Date', 'Count'],
            <?php
              foreach($user as $users) {
                  echo "['".$users->date."', ".$users->number."],";
              }
            ?>

        ]);

        var options = {
          chart: {
            title: 'Daily appllication',
            subtitle: 'application from June-July',
          },
          bars: 'horizontal' 
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
</head>
<body>
  <h2>Chart</h2>
  <form action="/date" method="POST">
    {{csrf_field()}}
    <input type="date" name="from" value="{{date('Y-m-d')}}">
    <input type="date" name="to" value="{{date('Y-m-d')}}">
    <input type="submit" value="View">
  </form>
  <br>
  <div id="barchart_material" style="width: 900px; height: 500px;"></div>
</body>
@endsection
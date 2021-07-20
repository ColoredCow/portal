@extends('layouts.app')


@section('content')
<div class="row"> 
    <div class="col-md-12 " >
        <br />
        <h3 align="left">Daily Applications</h3>
        <br />
        <table class= "table table-dark" >
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>College</th>
                <th>Date&Time</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Graduation Year</th>
            </tr>
            @foreach($all as $table)
            <tr>
               <td>{{ $table-> id}}</td>
               <td>{{ $table-> name}}</td>    
               <td>{{ $table-> college}}</td>   
               <td>{{ $table-> created_at}}</td>   
               <td>{{ $table-> phone}}</td>    
               <td>{{ $table-> email}}</td>  
               <td>{{ $table-> graduation_year}}</td>       
            </tr>        
            @endforeach 
        </table>
    </div>
</div>  

<br>

</br>

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
  <div id="barchart_material" style="width: 900px; height: 500px;"></div>
  
  </body>
</html>
@endsection
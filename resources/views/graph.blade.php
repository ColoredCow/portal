@extends('layouts.app')


@section('content')
<div class="row"> 
    <div class="col-md-12 " >
        <br />
        <h2 align="left">Daily Applications</h2>
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
            @foreach($table as $tables)
            <tr>
               <td>{{ $tables-> id}}</td>
               <td>{{ $tables-> name}}</td>    
               <td>{{ $tables-> college}}</td>   
               <td>{{ $tables-> created_at}}</td>   
               <td>{{ $tables-> phone}}</td>    
               <td>{{ $tables-> email}}</td>  
               <td>{{ $tables-> graduation_year}}</td>       
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
            title: 'Daily Appllication',
            subtitle: 'Application By Date',
          },
          bars: 'horizontal' 
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
</head>
<body>
  <h3>Date Range Search</h3>
  <form action="/dashboard" method="POST">
    {{csrf_field()}}
    <input type="date" name="from" value="{{date('Y-m-d')}}">
    <input type="date" name="to" value="{{date('Y-m-d')}}">
    <input type="submit" value="View">
  </form>
  <br>
  <h2>Chart</h2>
  <div id="barchart_material" style="width: 900px; height: 500px;"></div>
</body>
@endsection
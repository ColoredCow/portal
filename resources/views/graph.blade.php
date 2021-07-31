@extends('layouts.app')


@section('content')
<div class="row"> 
    <div class="col-md-6 " >
        <br>
        <h2 align="center">Daily Applications</h2>
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

<br>

<head>
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
 <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> 
</head>
<br>
<body>
<form action="/dashboard" method="POST">
    {{csrf_field()}}
    <input type="date" name="from" value="{{date('Y-m-d')}}">
    <input type="date" name="to" value="{{date('Y-m-d')}}">
    <input type="submit" value="View">
</form>
<br>
  <div class="chart-container" align="center">
    <div class="bar-chart-container" style="width : 800px">
      <canvas id="bar-chart"></canvas>
    </div>
  </div>
  <script>
  $(function(){
      var cData = JSON.parse(`<?php echo $chart_data; ?>`);
      var ctx = $("#bar-chart");
 
      var data = {
        labels: cData.label,
        datasets: [
          {
            label: "Count",
            data: cData.data,
            backgroundColor: ["#DEB887","#A9A9A9","#DC143C","#F4A460","#2E8B57","#1D7A46","#CDA776",],
            borderColor: ["#CDA776","#989898","#CB252B","#E39371","#F4A460","#1D7A46","#CDA776",],
            borderWidth: [1.5, 1.5, 1.5, 1.5, 1.5, 1.5, 1.5]
          }
        ]
      };
      var options = {
        responsive: true,
        title: {
          display: true,
          position: "top",
          text: "Daily Application Count",
          fontSize: 18,
          fontColor: "#212408"
        },
        legend: {
          display: true,
          position: "right",
          labels: {
            fontColor: "#333",
            fontSize: 16
          }
        },
        scales: {
        yAxes: [{
          ticks: { min: 1, max: 5, stepSize: 1, suggestedMin: 0.5, suggestedMax: 5.5},
        }]
        },   
        
      };
 
       var chart1 = new Chart(ctx, {
        type: "bar",
        data: data,
        options: options
      });
  });
</script>

</body>  
@endsection
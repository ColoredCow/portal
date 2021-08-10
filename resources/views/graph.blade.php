@extends('layouts.app')


@section('content')
<head>
   <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> 
</head>
<br>
<body>
  <div class="chart-container" align="center">
   <div class="line-chart-container" style="width : 1000px">
      <h2 align="left">Analytics</h2>
      <form action="/dashboard" method="POST" align="right">
        {{csrf_field()}}
        <input type="date" name="from" id='StartDate'> to 
        <input type="date" name="to" id="EndDate">
        <input type="submit" value="View"> 
      </form>  
      <br>
      <div class="card">
        <div class="card-header" align='left'>
          <span style="font-size: 35px;">Application Recived</span> &emsp;&emsp; <span style="font-size: 20px;">Today's Count:<?php echo $todayCount; ?></span> 
        </div>
        <div class="card-body">
          <canvas id="line-chart"></canvas>
        </div>
      </div>
      <script>
        $(function(){
          $("#EndDate").change(function () {
            var startDate = document.getElementById("StartDate").value;
            var endDate = document.getElementById("EndDate").value;
            if ((Date.parse(endDate) <= Date.parse(startDate))) {
              alert("End date should be greater than Start date");
              document.getElementById("EndDate").value = "";
            }
          });
        });
        $(function(){
        var cData = JSON.parse(`<?php echo $chart_data; ?>`);
        var ctx = $("#line-chart");

            var data = {
              labels: cData.label,
              datasets: [
                {
                  label: "Count",
                  data: cData.data,
                  backgroundColor: "#67A7E2",
                  borderColor:"#67A7E2",
                  borderWidth: 1,
                  pointHoverRadius: 7
                }
              ]
            };
            var options = {
              responsive: true,
              tooltips:{
                displayColors:false,
                bodyFontSize: 20,
                bodyFontStyle: 'bold',
                //backgroundColor:"#E5E5E5",
                //bodyFontColor:"#E0DEDE",
                cornerRadius:0,
                borderWidth:2
              },
              title: {
              display: false,
              },
              legend: {
              display: false,
              }, 
              scales: {
                yAxes: [{
                ticks: { min: 0, max: 5, stepSize: 1, suggestedMin: 0.5, suggestedMax: 5.5},
                }]
              },  
              elements: {
              line: {
                fill: false,
                tension: 0
                },
              point:{
                radius:0
              }
            }   
          };

          var charts = new Chart(ctx, {
            type: "line",
            data: data,
            options: options
          });
        });
      </script>
   </div> 
 </div>
</body>
       
@endsection

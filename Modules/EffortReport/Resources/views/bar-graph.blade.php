@extends('effortreport::layouts.master')
@section('content')
@include('hr.employees.sub-views.menu')
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Getting Started with Chart JS with www.chartjs3.com</title>
    <style>
      * {
        margin: 0;
        padding: 0;
        font-family: sans-serif;
      }
      .chartMenu {
        margin-left: 2px;
        width: 95vw;
        height: 40px;
        background: #1A1A1A;
        color: rgba(255, 26, 104, 1);
      }
      .chartMenu h3 {
        padding: 12px;
        font-size: 22px;
        color: white;
      }
      .chartCard {
        margin-left: 2px;
        width: 95vw;
        height: calc(100vh - 40px);
        background: rgba(255, 16, 104, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .chartBox {
        width: 700px;
        padding: 20px;
        border-radius: 20px;
        border: solid 3px rgba(255, 26, 104, 1);
        background: white;
      }
    </style>
  </head>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.js"></script>
  <body>
    <div class="chartMenu">
      <h3>Efforts of: {{$employee->name}}</h3>
    </div>
    <div class="chartCard">
      <div class="chartBox">
        <canvas id="myChart"></canvas>
      </div>
    </div>
    <script>
    var chartDataInJs = @json($chartData);
    var datasetsMap = [];

    for(let i = 0; i < chartDataInJs.efforts.length; i++) {
      let datasetItem = {
        label: chartDataInJs.projects[i],
        data:  chartDataInJs.efforts[i],
        backgroundColor: chartDataInJs.colors[i]
      };
      datasetsMap.push(datasetItem);
    };

    var data = {
      labels: Object.values(chartDataInJs.labels),
      datasets: datasetsMap,
    };
    var barChartOptions = {
      title: {
      display: false,
      text: 'Chart.js Stacked Bar Chart'
  },
    tooltips: {
      mode: 'index',
      intersect: false
  },
  responsive: true,
  scales: {
    xAxes: [{
      stacked: true,
    }],
    yAxes: [{
      stacked: true,
      ticks: {
        precision: 0
      }
    }]
  }
}

var ctx = document.getElementById('myChart').getContext('2d');
window.myBar = new Chart(ctx, {
  type: 'bar',
  data: data,
  options: barChartOptions
});
</script>
</body>
</html>
@endsection
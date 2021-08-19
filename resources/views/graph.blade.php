@extends('layouts.app')

@section('content')

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
       <a id="value" value="{{ $chart_data }}"></a>
   </div>
 </div>
</body>

@endsection

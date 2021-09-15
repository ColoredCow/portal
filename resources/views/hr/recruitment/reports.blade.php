@extends('layouts.app')

@section('content')

<body>
    <div class="chart-container" align="center">
        <div class="line-chart-container">
            <h2 align="left">Analytics</h2>
            <form action="{{route('recruitment.reports')}}" method="POST" align="right">
                {{csrf_field()}}
                <input type="date" name="from" id='StartDate'> to
                <input type="date" name="to" id="EndDate">
                <input type="submit" value="View">
            </form>
            <br>

            <div class="card">
                <div class="card-header" align='left'>
                    <span class="chartHeading">Application Received</span> &emsp;&emsp; <span class="totalChartCount">Today's Count:<?php echo $todayCount ?></span>
                </div>
                <div class="card-body chartdata" data-target="{{ $chartData }}" >
                    <canvas id="line-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
</body>

@endsection

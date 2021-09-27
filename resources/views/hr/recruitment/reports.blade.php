@extends('layouts.app')

@section('content')

<div class="chart-container" align="center">
    <div class="line-chart-container">
        <h2 align="left">Analytics</h2>
        <form action="{{route('recruitment.reports')}}" method="POST" align="right">
            {{csrf_field()}}
            <input type="date" name="report_start_date" id='StartDate'> to
            <input type="date" name="report_end_date" id="EndDate">
            <input type="submit" value="View">
        </form>
        <br>

        <div class="card">
            <div class="card-header" align='left'>
                <span class="chart-heading mr-5">Application Received</span><span class="total-chart-count">Today's Count:<?php echo $todayCount ?></span>
            </div>
            <div class="card-body chart-data" data-target="{{ $chartData }}" >
                <canvas id="line-chart"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

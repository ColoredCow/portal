@extends('layouts.app')

@section('content')

<div class="chart-container" align="center">
    <div class="bar-chart-container">
        <div class="d-flex justify-content-between">
             <div>
                <h2>Analytics </h2>
            </div>
            <div>
                <form action="{{route('recruitment.report')}}" method="POST" align="right">
                    {{csrf_field()}}
                    <input type="date" name="report_start_date" id='StartDate'> to
                    <input type="date" name="report_end_date" id="EndDate">
                    <input type="submit" class="btn btn-sm btn-primary text-white" value="View">
                </form>
                <br>
            </div>
        </div>
        <div class="card">
            <div class="card-header" align='left'>
                <span class="chart-heading mr-5">Application Received</span><span class="total-chart-count">Today's Count:<?php echo $todayCount ?></span>
            </div>
            <div class="card-body chart-data" data-target="{{ $chartData }}" >
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

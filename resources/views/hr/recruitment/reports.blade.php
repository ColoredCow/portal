@extends('layouts.app')

@section('content')
    <div class="chart-container" align="center">
        <div class="bar-chart-container">
            <div class="d-flex justify-content-between">
                <div class="my-2">
                    <div align="left">
                        <h2><span class="chart-heading-mr-5">Analytics</span></h2>
                        <h3><span class="total-chart"> Total Verified Applications: <?php echo $verifiedApplicationsCount; ?></span></h3>
                    </div>
                </div>
                <div class="my-2">
                    <form action="{{ route('recruitment.report') }}" method="POST" align="right">
                        {{ csrf_field() }}
                        <input type="date" name="report_start_date" id='StartDate'
                            value="{{ old('report_start_date', request()->get('report_start_date')) }}" required> to
                        <input type="date" name="report_end_date" id="EndDate"
                            value="{{ old('report_end_date', request()->get('report_end_date')) }}" required>
                        <input type="submit" class="btn btn-sm btn-primary text-white" value="View">
                    </form>
                    <br>
                </div>
            </div>
            <div class="card">
                <div class="card-header" align='left'>
                    <span class="chart-heading mr-5">Application Received</span><span class="total-chart-count">Today's
                        Count:<?php echo $todayCount; ?></span>
                </div>
                <div class="card-body chart-data" data-target="{{ $chartData }}">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')

  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="round-wise-rejections-tab" data-toggle="tab" href="#round-wise-rejections" role="tab" aria-controls="round-wise-rejections" aria-selected="true">Round wise rejections</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="rejection-reasons-tab" data-toggle="tab" href="#rejection-reasons" role="tab" aria-controls="rejection-reasons" aria-selected="false">Rejection reasons</a>
    </li>
  </ul>

  <div class="tab-content">
    <div class="tab-pane active" id="round-wise-rejections" role="tabpanel" aria-labelledby="round-wise-rejections-tab">
      <div Class="my-2">
        <form class="form-inline text-right" action="{{route('recruitment.rejected-applications')}}" method="get" align="Right">
          <div class="form-group">
            <input type="date" name="start_date" id="start_date" class="form-control-sm" required> 
          </div>
          <span class="mx-2">to</span>
          <div class="form-group">
            <input type="date" name="end_date" id="end_date" class="form-control-sm" required>
          </div>
          <div class="form-group">
            <button class="btn btn-primary btn-sm ml-2" type="submit">View</button>
          </div>
        </form>
      </div>
      <div class="card">
        <div class="card-header" align='left'>
            <span class="chart-heading mr-5">Rounds</span><span class="total-chart-count">Total rejected application count</span>
        </div>
        <div class="card-body chart-data" data-target="{{ $chartData }}">
            <canvas id="myGraph" data-target="{{ $chartData }}"></canvas>
        </div>
      </div>
    </div>

    <div class="tab-pane" id="rejection-reasons" role="tabpanel" aria-labelledby="rejection-reasons-tab">
      <div Class="my-2">
        <form class="form-inline text-right" action="{{route('recruitment.rejected-applications')}}" method="get" align="Right">
          <div class="form-group">
            <input type="date" name="start_date" id="start_date" class="form-control-sm" required> 
          </div>
          <span class="mx-2">to</span>
          <div class="form-group">
            <input type="date" name="end_date" id="end_date" class="form-control-sm" required>
          </div>
          <div class="form-group">
            <button class="btn btn-primary btn-sm ml-2" type="submit">View</button>
          </div>
        </form>
      </div>
      <div class="card">
        <div class="card-header" align='left'>
            <span class="chart-heading mr-5">Rejected Reason</span><span class="total-chart-count">rejected application count</span>
        </div>
        <div class="card-body chart-data" data-target="{{ $chartBarData }}">
            <canvas id="myBarGraph" data-target="{{ $chartBarData }}"></canvas>
        </div>
      </div>
    </div>
  </div>

@endsection

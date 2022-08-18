@extends('layouts.app')

@section('content')

  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link" id="round-wise-rejections-tab" data-toggle="tab" href="#round-wise-rejections" role="tab" aria-controls="round-wise-rejections" aria-selected="true">Round wise rejections</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" id="rejection-reasons-tab" data-toggle="tab" href="#rejection-reasons" role="tab" aria-controls="rejection-reasons" aria-selected="false">Rejection reasons</a>
    </li>
  </ul>

  <div class="tab-content">
    <div class="tab-pane" id="round-wise-rejections" role="tabpanel" aria-labelledby="round-wise-rejections-tab">
      <div class="card">
        <div class="card-header" align='left'>
          <span class="chart-heading mr-5">Rounds</span><span class="total-chart-count">Total rejected application count</span>
          <span>
            <div class="d-inline-flex p-2 ml-25" >
              <form id="filterform1" action="{{ route('recruitment.rejected-applications') }}" method="get" align="Right">
                <input type="date" name="Start_date" id="StartDate" value="{{ old('Start_date', request()->get('Start_date')) }}" required> to
                <input type="date" name="End_date" id="EndDate" value="{{ old('End_date', request()->get('End_date')) }}" required>
                <input type="submit" id="Saveview" class="btn btn-sm btn-primary text-white" value="View">
              </form>
            </div>
          </span>
        </div>
        <div class="card-body chart-data" data-target="{{ $chartData }}">
          <canvas id="myGraph" data-target="{{ $chartData }}"></canvas>
        </div>
      </div>
    </div>

    <div class="tab-pane active" id="rejection-reasons" role="tabpanel" aria-labelledby="rejection-reasons-tab">
      
      <div class="card">
        <div class="card-header" align='left'>
          <span class="chart-heading mr-5">Rejected Reason</span><span class="total-chart-count">rejected application count</span>
          <span>
            <div class="d-inline-flex p-2 ml-20" >
              <form id="filterform" action="{{ route('recruitment.rejected-applications') }}" method="get" align="Right">
                <input type="date" name="start_date" id="StartDate" value="{{ old('start_date', request()->get('start_date')) }}" required> to
                <input type="date" name="end_date" id="EndDate" value="{{ old('end_date', request()->get('end_date')) }}" required>
                <input type="submit" id="Saveview" class="btn btn-sm btn-primary text-white" value="View">
              </form>
            </div>
          </span>
        </div>
        <div id="BarGraph" class="card-body chart-data" data-target="{{ $chartBarData }}">
          <canvas id="myBarGraph" data-target="{{ $chartBarData }}"></canvas>
        </div>
      </div>
    </div>
  </div>

@endsection

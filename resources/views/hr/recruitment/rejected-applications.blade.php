@extends('layouts.app')

@section('content')

  <ul class="nav nav-pills justify-content-center" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link {{ request('tabId') == 'tab1' ?  'active' : ' ' }}" id="tab1" data-toggle="tab" href="#round-wise-rejections" role="tab" aria-controls="round-wise-rejections" aria-selected="false">Round wise rejections</a>
    </li>
    <li class="nav-item">
      <a class="nav-link  {{ request('tabId') == 'tab2' ?  'active' : ' ' }}" id="tab2" data-toggle="tab" href="#rejection-reasons" role="tab" aria-controls="rejection-reasons" aria-selected="false">Rejection reasons</a>
    </li>
  </ul><br>

  <div class="tab-content d-flex justify-content-center ">
    <div class="tab-pane {{ request('tabId') == 'tab1' ?  'active' : ' ' }}" id="round-wise-rejections" role="tabpanel" aria-labelledby="round-wise-rejections-tab">
      <div class=" card " >
        <div class="card-header d-flex justify-content-center" align='left'>
          <span class="total-chart-count mr-25">Total rejected application count</span>
          <span>
            <div class="d-inline-flex ml-25" >
              <form id="filterform1" action="{{ route('recruitment.rejected-applications') }}" method="get" align="Right">
                <input type="date" name="Start_date" id="StartDate" value="{{ old('Start_date', request()->get('Start_date')) }}" required> to
                <input type="date" name="End_date" id="EndDate" value="{{ old('End_date', request()->get('End_date')) }}" required>
                <input  name="tabId" type="hidden" value="tab1">
                <input type="submit" id="Saveview" class="btn btn-sm btn-primary text-white" value="View">
              </form>
            </div>
          </span>
        </div>
        <div class="card-body chart-data" data-target="{{ $chartData }}">
          <canvas id="myGraph" data-target="{{ $chartData }}"width="700%" height="280px"></canvas>
        </div>
      </div>
    </div>
    <div class="tab-pane {{ request('tabId') == 'tab2' ?  'active' : ' ' }}" id="rejection-reasons" role="tabpanel" aria-labelledby="rejection-reasons-tab">
      <div class="card">
        <div class="card-header d-flex justify-content-center" align='left'>
          <span class="total-chart-count mr-25">Rejected Application Count</span>
          <span>
            <div class="d-inline-flex ml-25" >
              <form id="filterform" action="{{ route('recruitment.rejected-applications') }}" method="get" align="Right">
                <input type="date" name="start_date" id="StartDate" value="{{ old('start_date', request()->get('start_date')) }}" required> to
                <input type="date" name="end_date" id="EndDate" value="{{ old('end_date', request()->get('end_date')) }}" required>
                <input  name="tabId" type="hidden" value="tab2">
                <input type="submit" id="Saveview" class="btn btn-sm btn-primary text-white" value="View">
              </form>
            </div>
          </span>
        </div>
        <div id="BarGraph" class="card-body chart-data" data-target="{{ $chartBarData }}">
          <canvas id="myBarGraph" data-target="{{ $chartBarData }}" width="700%" height="250px"></canvas>
        </div>
      </div>
    </div>
  </div>

@endsection

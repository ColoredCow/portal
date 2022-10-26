@extends('layouts.app')

@section('content')

  <ul class="nav nav-pills justify-content-center" id="myTab" role="tablist">
    <li class="nav-item">
      <title class="nav-link {{ request('date_filter_input') == 'roundWiseRejectionDateFilterValue' || !request()->has('date_filter_input')  ?  'active' : ' ' }}" id="roundWiseReasonsTab" data-toggle="tab" href="#round-wise-rejections" role="tab" aria-controls="round-wise-rejections" aria-selected="false">Application Rounds Duration</title>
    </li>
  </ul><br>

  <div class="tab-content d-flex justify-content-center ">
    <div class="tab-pane {{ request('date_filter_input') == 'roundWiseRejectionDateFilterValue' || !request()->has('date_filter_input') ?  'active' : ' ' }}" id="round-wise-rejections" role="tabpanel" aria-labelledby="round-wise-rejections-tab">
      <div class=" card " >
        <div class="card-header d-flex justify-content-center" align='left'>
          <span class="total-chart-count mr-25">Total rejected application count</span>
          <span>
            <div class="d-inline-flex ml-25" >
              <form id="filterform1" action="{{ route('recruitment.rejected-applications') }}" method="get" align="Right">
                <input type="date" name="round_wise_rejection_start_date" id="startDate" value="{{ old('round_wise_rejection_start_date', request()->get('round_wise_rejection_start_date')) }}" required> to
                <input type="date" name="round_wise_rejection_end_date" id="endDate" value="{{ old('round_wise_rejection_end_date', request()->get('round_wise_rejection_end_date')) }}" required>
                <input  name="date_filter_input" type="hidden" value="roundWiseRejectionDateFilterValue">
                <input type="submit" id="Saveview" class="btn btn-sm btn-primary text-white" value="View">
              </form>
            </div>
          </span>
        </div>
        <div class="card-body chart-data" data-target="{{ $durationData }}">
          <canvas id="myGraphDuration" data-target="{{ $durationData }}"width="500%" height="280px"></canvas>
        </div>
      </div>
  </div>
@endsection

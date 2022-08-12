@extends('layouts.app')

@section('content')

<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link" id="round-wise-rejections-tab" data-toggle="tab" href="#round-wise-rejections" role="tab" aria-controls="round-wise-rejections" aria-selected="false">Round wise rejections</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="rejection-reasons-tab" data-toggle="tab" href="#rejection-reasons" role="tab" aria-controls="rejection-reasons" aria-selected="false">Rejection reasons</a>
    </li>
  </ul>
  
  <div class="tab-content">
      <div class="tab-pane" id="round-wise-rejections" role="tabpanel" aria-labelledby="round-wise-rejections-tab">
        <h1>round wise rejection graph</h1>
        <canvas id="myGraph" data-target="{{ $chartData }}" width="120%" height="150px" style="display: block; box-sizing: border-box; height: 478.182px; width: 957.273px;"></canvas>
      </div>
    
    <div class="tab-pane" id="rejection-reasons" role="tabpanel" aria-labelledby="rejection-reasons-tab">
      <h1>rejected reason BarChart</h1>
      <canvas id="myBarGraph" data-target="{{ $chartBarData }}" width="120%" height="150px"></canvas>
    </div>

  </div>

@endsection

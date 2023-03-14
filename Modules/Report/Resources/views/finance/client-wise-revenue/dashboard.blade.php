@extends('report::layouts.finance')
@section('content')
    <div class="container" id="vueContainer">
        <br>
        <br>

        <div class="d-flex justify-content-between mb-2">
            <h2 class="mb-1 pb-1 font-muli-bold">Revenue by client</h2>
        </div>

        <div>
            <div class="d-flex justify-content-start row flex-wrap">
                <div class="col-md-3">
                    <div class="card">
                        <a class="card-body text-decoration-none d-flex"
                            href="{{ route('reports.finance.dashboard.client') }}">
                            <h2 class="text-center mb-0">Revenue Visualization</h2><br>
                        </a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card bg-theme-gray-lighter">
                        <a class="card-body text-decoration-none d-flex"
                            href="#">
                            <h2 class="text-center mb-0">Client Revenue Report</h2><br>
                        </a>
                    </div>
                </div>
                
            </div>
        </div>

    </div>
@endsection

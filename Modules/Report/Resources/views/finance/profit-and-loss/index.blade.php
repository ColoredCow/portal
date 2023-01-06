@extends('report::layouts.finance')
@section('content')
    <div class="container" id="vueContainer">
        <br>
        <br>

        <div class="d-flex justify-content-between mb-2">
            <h2 class="mb-1 pb-1 font-muli-bold">Profit and Loss</h2>
        </div>

        <h3> Actuals </h3>
        <div>
            <div class="d-flex justify-content-start row flex-wrap">
                <div class="col-md-3">
                    <div class="card">
                        <a class="card-body text-decoration-none d-flex"
                            href="{{ route('reports.finance.profit-and-loss.detailed') }}">
                            <h2 class="text-center mb-0">Detailed P&L Report</h2><br>
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-theme-gray-lighter">
                        <a class="card-body text-decoration-none d-flex" href="#">
                            <h2 class="text-center mb-0"> Variance reasons</h2><br>
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card  bg-theme-gray-lighter">
                        <a class="card-body text-decoration-none d-flex" href="#">
                            <h2 class="text-center mb-0">Big ticket changes </h2><br>
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card  bg-theme-gray-lighter">
                        <a class="card-body text-decoration-none d-flex" href="#">
                            <h2 class="text-center mb-0">Location wise profitability</h2><br>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="mt-2"> Budget </h3>
        <div>
            <div class="d-flex justify-content-start row flex-wrap">
                <div class="col-md-3">
                    <div class="card bg-theme-gray-lighter">
                        <a class="card-body text-decoration-none d-flex" href="#">
                            <h2 class="text-center mb-0">Variance reasons</h2><br>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('report::layouts.finance')
@section('content')
    <div class="container" id="vueContainer">
        <div class="d-flex justify-content-between my-2">
            <h2 class="mb-1 pb-1 font-muli-bold">Finance Dashboard</h2>
        </div>

        <div>
            <div class="mt-4 container">
                <h3>
                    Invoice Details
                </h3>
                <canvas class="w-full" id="financeReportRevenueTrends"></canvas>
            </div>
        </div>

        <div class="mt-4">
            <div class="d-flex justify-content-start row flex-wrap">
                <div class="col-md-3">
                    <div class="card h-75 ">
                        <a class="card-body no-transition" href="{{ route('reports.finance.profit-and-loss.index') }}">
                            <h2 class="text-center">Profit and Loss</h2><br>
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-75 ">
                        <a class="card-body no-transition" href="{{ route('invoice.details') }}">
                            <h2 class="text-center">Monthly GST</h2><br>
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-75 ">
                        <a class="card-body no-transition" href="{{ route('invoice.tax-report') }}">
                            <h2 class="text-center">Monthly Tax</h2><br>
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-75 ">
                        <a class="card-body no-transition" href="#">
                            <h2 class="text-center">Yearly Invoice</h2><br>
                        </a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card h-75">
                        <a class="card-body no-transition" href="{{ route('reports.finance.dashboard.client') }}">
                            <h2 class="text-center">Revenue by client</h2><br>
                        </a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card h-75 bg-theme-gray-lighter">
                        <a class="card-body text-decoration-none" href="#">
                            <h2 class="text-center">New Business</h2><br>
                        </a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card h-75 bg-theme-gray-lighter">
                        <a class="card-body text-decoration-none" href="#">
                            <h2 class="text-center">Pipeline</h2><br>
                        </a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card h-75 bg-theme-gray-lighter">
                        <a class="card-body text-decoration-none" href="#">
                            <h2 class="text-center">Employees</h2><br>
                        </a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card h-75 bg-theme-gray-lighter">
                        <a class="card-body text-decoration-none" href="#">
                            <h2 class="text-center">Investments</h2><br>
                        </a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card h-75 bg-theme-gray-lighter">
                        <a class="card-body text-decoration-none" href="#">
                            <h2 class="text-center">Operational</h2><br>
                        </a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card h-75 bg-theme-gray-lighter">
                        <a class="card-body text-decoration-none" href="#">
                            <h2 class="text-center">Competitor</h2><br>
                        </a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card h-75 bg-theme-gray-lighter">
                        <a class="card-body text-decoration-none" href="#">
                            <h2 class="text-center">Cash reports</h2><br>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

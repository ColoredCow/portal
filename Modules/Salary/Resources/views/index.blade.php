@extends('salary::layouts.master')

@section('content')
<div class="container">
    <br>
    <div class="d-flex justify-content-start row flex-wrap">
        @can('library_books.view')
        <div class="col-md-4">
            <div class="card h-75 mx-4 mt-3 mb-5 ">
                <a class="card-body no-transition" href="{{ route('salary-settings.index') }}">
                    <br>
                    <h2 class="text-center">Settings</h2><br>
                </a>
            </div>
        </div>
        @endcan
        @can('weeklydoses.view')
        <div class="col-md-4">
            <div class="card h-75 mx-4 mt-3 mb-5 ">
                <a class="card-body no-transition" href="{{ route('weeklydoses') }}">
                    <br>
                    <h2 class="text-center">Employee Salaries</h2><br>
                </a>
            </div>
        </div>
        @endcan
    </div>
</div>
@endsection
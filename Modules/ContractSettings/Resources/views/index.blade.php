@extends('client::layouts.master')

@section('content')
<div class="container"><br>
    <div class="d-flex justify-content-between">
        <div>
            <h2 class="mb-3">Add Contract Links</h2>
        </div>
    </div>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
        <tr>
            <th>{{ __('Billing Type') }}</th>
            <th>{{ __('Links') }}</th>
            <th>{{ __('Actions') }}</th>
        </tr>
        @foreach(config('contractsettings.billing_level') as $billingType)
        <tr>
            <td>{{ $billingType }}</td>
            <td>
                <!-- Place your code for links here -->
            </td>
            <td>
                <!-- Place your code for actions here -->
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection

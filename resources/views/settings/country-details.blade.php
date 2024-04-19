@extends('layouts.app')

@section('content')
<div class="container"><br>
    <div class="d-flex justify-content-between">
        <div>
            <h2 class="mb-3">Country Details</h2>
        </div>
    </div>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
        <tr>
            <th>{{ __('Country') }}</th>
            <th>{{ __('Initials') }}</th>
            <th>{{ __('Currency') }}</th>
            <th>{{ __('Currency Symbol') }}</th>
            <th>{{ __('Edit') }}</th>
            <th>{{ __('Delete') }}</th>
        </tr>
        @foreach($countryDetails as $country)
            <tr>
                <td>{{ $country->name }}</td>
                <td>{{ $country->initials }}</td>
                <td>{{ $country->currency }}</td>
                <td>{{ $country->currency_symbol }}</td>
                <td>
                    <button type="button" class="pr-1 btn btn-link" data-toggle="modal" data-target="#countryEditFormModal{{$country->id}}" data-json="{{$country}}"><i class="text-success fa fa-edit fa-lg"></i></button>
                </td>
                <td>
                    <form action="{{ route('country.delete', ['id' => $country->id]) }}" method="post">
                        @csrf
                        <button type="submit" class="pl-1 btn btn-link" onclick="return confirm('Are you sure you want to delete?')"><i class="text-danger fa fa-trash fa-lg"></i></button>
                    </form>
                </td>
            </tr>
            @include('settings.edit-country-details')
        @endforeach
    </table>
</div>
@endsection
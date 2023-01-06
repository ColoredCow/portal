@extends('operation::layouts.master')
@section('content')
    <div class="container" id="vueContainer">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th class="sticky-top">Name</th>
                        <th class="sticky-top">Center Head</th>
                        <th class="sticky-top">Capacity</th>
                        <th class="sticky-top">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($officeLocations as $officeLocation)
                        <tr>
                            <td class="font-weight-bold">{{ $officeLocation['location'] }}</td>
                            <td class="font-weight-bold">{{ $officeLocation['center_head'] }}</td>
                            <td class="font-weight-bold">{{ $officeLocation['capacity'] }}</td>
                            <td class="font-weight-bold">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editLocationsModal">Edit</button>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteLocationsModal">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <p class="my-4 text-left"> No
                                    {{ config('project.status')[request()->input('status', 'active')] }}
                                    {{ ' ' }}
                                    {{ request()->input('is_amc', '0') == '1' ? 'AMC' : 'Main' }}
                                    projects found.
                                </p>
                            <td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $officeLocations->withQueryString()->links() }}
    </div>
@endsection
@include('operation::location.locationModal', ['users' => $users])

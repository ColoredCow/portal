@extends('operations::layouts.master')

@section('content')
<div class="container">
    <div>
        @include('operations::modals.add-center-modal')
    </div>

    <br><br>

    <div>
        <br>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th class="col-md-2">Centre Name</th>
                    <th class="col-md-2">Centre Head</th>
                    <th class="col-md-2">Capacity</th>
                    <th class="col-md-2">Current People Count</th>
                    <th class="col-md-1">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($centres as $centre)
                <tr>
                    <td>{{ $centre->centre_name }}</td>
                    <td>{{ $centre->centre_head->name }}</td>
                    <td>{{ $centre->capacity }}</td>
                    <td>{{ $centre->current_people_count }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('office-location.edit', $centre->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i></a>
                            <form action="{{ route('office-location.destroy', $centre->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger" style="margin-left: 5px;" data-toggle="modal" data-target="#confirm-delete-{{ $centre->id }}"><i class="fa fa-trash-o"></i></button>
                                @include('component.delete-modal', [
                                    'modalId' => 'confirm-delete-' . $centre->id,
                                    'title' => 'Confirm Delete',
                                    'body' => 'Are you sure you want to remove this centre?',
                                    'action' => route('office-location.destroy', $centre->id)
                                ])
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

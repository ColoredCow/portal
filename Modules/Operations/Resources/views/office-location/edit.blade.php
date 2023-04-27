@extends('operations::layouts.master')

@section('content')
<div class="container">
    <div>
        <br>
        <form action="{{ route('office-location.update', $centre->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="centreName" class="field-required">Centre Name</label>
                    <input type="text" class="form-control" name="centre_name" id="centreName" placeholder="Centre Name" required="required" value="{{ $centre->centre_name }}">
                </div>
                <div class="form-group col-md-6">
                    <label for="centreHead" class="field-required">Centre Head</label>
                    <select v-model="location" name="centre_head" id="centreHead" class="form-control" required>
                        <option value="">Select centre head</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $user->id == $centre->centre_head->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="capacity" class="field-required">Capacity</label>
                    <input type="number" class="form-control" name="capacity" id="capacity" placeholder="Enter Capacity" required="required" value="{{ $centre->capacity }}">
                </div>
                <div class="form-group col-md-6">
                    <label for="currentPeopleCount" class="field-required">Current People Count</label>
                    <input type="number" class="form-control" name="current_people_count" id="currentPeopleCount" placeholder="Enter current people" required="required" value="{{ $centre->current_people_count }}">
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('office-location.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

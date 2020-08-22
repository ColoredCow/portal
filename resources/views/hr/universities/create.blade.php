@extends('layouts.app')

@section('content')
<div class="container" id="project_container">
    <br>
    @include('hr.universities.menu', ['active' => 'universities'])
    <br><br>
    <h1>Add University</h1>
    @include('status', ['errors' => $errors->all()])
    <div class="card">
        <form action="{{ route('universities.store') }}" method="POST" id="form_universities">
            {{ csrf_field() }}
            <div class="card-header">
                <span>University Details</span>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="name" class="field-required">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" required="required" value="{{ old('name') }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="address" class="field-required">Address</label>
                        <input type="text" class="form-control" name="address" id="address" placeholder="Address" required="required" value="{{ old('address') }}">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </form>
    </div>
</div>
@endsection


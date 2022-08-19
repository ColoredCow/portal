@extends('layouts.app')

@section('content')
<div class="card-body">
    <div>
        @if(session('message'))
        <div class="alert alert-success">
            <h4>{{ session('message') }}
        </div>
        @endif
        <form action="{{route('setting.create.organization')}}" method="POST">
            @csrf
        <div class="form-group col-md-5">
            <label for="name" class="field-required">Name</label>
            <input type="text" class="form-control" name="name" placeholder="Organization" required>
                @error('name') <small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="form-group col-md-5">
            <label for="address" class="field-required">Address</label>
            <input type="text" class="form-control" name="address" placeholder="Address" required>
            @error('address') <small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="form-group col-md-5">
            <label for="annual_sale" class="field-required">Annual Sales</label>
            <input type="number" class="form-control" name="annual_sales"  placeholder="Annual Sales" required>
            @error('annual_sales') <small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="form-group col-md-5">
            <label for="members" class="field-required">Members</label>
            <input type="number" class="form-control" name="members" placeholder="Members Count" required>
            @error('members') <small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="form-group col-md-5">
            <label for="industry" class="field-required">Industry</label>
            <input type="text" class="form-control" name="industry" placeholder="Industry" required>
            @error('industry') <small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="form-group col-md-5">
            <label for="email" class="field-required">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Organization Email" required>
            @error('email') <small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="form-group col-md-5">
            <label for="billing_details" class="field-required">Billing Details</label>
            <input type="text" class="form-control" name="billing_details" placeholder="Billing Details" required>
            @error('billing_details') <small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="form-group col-md-5">
            <label for="website" class="field-required">Website</label>
            <input type="text" class="form-control" name="website" placeholder="Website" required>
            @error('website') <small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="ml-2 mt-1">
        <button type="submit" class="btn btn-primary" id="save-btn-action">Submit</button>
        </div>
        </form>
    </div>
</div>


@endsection
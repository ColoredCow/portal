@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <h1>Edit Client</h1>
    <br>
    <a class="btn btn-info" href="/clients">See all clients</a>
    <br><br>
    @include('status', ['errors' => $errors->all()])
    <br>
    <div class="card">
        <form action="/clients/{{ $client->id }}" method="POST" class = "client-form" >

            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            <div class="card-header">
                <span>Client Details</span>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="name" class="field-required">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" required="required" value="{{ $client->name }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{ $client->email }}">
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone" value="{{ $client->phone }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="country">Country</label>
                        <select name="country" id="country" class="form-control">
                            <option value="">Select country</option>
                            @foreach (config('constants.countries') as $country => $country_name)
                                @php
                                    $selected = $client->country == $country ? 'selected="selected"' : '';
                                @endphp
                                <option value="{{ $country }}" {{ $selected }}>{{ $country_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                
                <div class="form-row" style="display:{{($client->country != 'india') ? 'none': ''}}">
                    <div class="form-group col-md-5">
                        <label for="phone">GST</label>
                        <input type="text" class="form-control" name="gst_num" id="gst_num" placeholder="GST Num" value="{{ $client->gst_num }}">
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="name">Address</label>
                        <textarea name="address" id="address" rows="5" class="form-control" placeholder="Address">{{ $client->address }}</textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

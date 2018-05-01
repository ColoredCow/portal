@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('finance.menu', ['active' => 'clients'])
    <br><br>
    <div class="row">
        <div class="col-md-6"><h1>Edit Client</h1></div>
        <div class="col-md-6"><a href="/clients/create" class="btn btn-success float-right">Create Client</a></div>
    </div>
    @include('status', ['errors' => $errors->all()])
    <div class="card">
        <form action="/clients/{{ $client->id }}" method="POST"  id="client_form" >

            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            <div class="card-header d-flex align-items-center">
                <label class="d-inline mb-0 mr-2">Status:</label>
                <label class="switch mb-0">
                    <input type="checkbox" id="is_active" name="is_active" value="1" v-model="isActive" data-pre-select-status="{{ $client->is_active }}">
                    <div class="slider round" @click="toggleActive" :class="[isActive ? 'active' : 'inactive']" >
                        <span class="on w-100 text-left pl-3">Active</span>
                        <span class="off w-100 text-right pr-3">Inactive</span>
                    </div>
                </label>
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
                    <div class="form-group offset-md-1 col-md-3">
                        <label for="country">Country</label>
                            <select name="country" id="country" class="form-control" data-pre-select-country="{{$client->country}}" v-model="country" >
                            <option value="">Select country</option>
                            @foreach (config('constants.countries') as $country => $country_name)
                                <option value="{{ $country }}" >{{ $country_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-2" v-if="country === 'india'">
                        <label for="gst_num">GST</label>
                        <input type="text" class="form-control" name="gst_num" id="gst_num" placeholder="GST Number" value="{{ $client->gst_num }}">
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="address">Address</label>
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

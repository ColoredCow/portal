@extends('layouts.app')

@section('content')
<div class="container" id="project_container">
    <br>
    @include('hr.universities.menu', ['active' => 'universities'])
    <br><br>
    <div class="row">
        <div class="col-md-6"><h1>Edit University</h1></div>
        <div class="col-md-6"><a href="{{ route('universities.create') }}" class="btn btn-success float-right">Add University</a></div>
    </div>
    @include('status', ['errors' => $errors->all()])
    <div class="card">
        <form action="{{ route('universities.update',$university->id) }}" method="POST" id="form_edit_universities">

            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="card-header">
                <span>University Details</span>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="name" class="field-required">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" required="required" value="{{$university->name}}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="address" class="field-required">Address</label>
                        <input type="text" class="form-control" name="address" id="address" placeholder="Address" required="required" value="{{$university->address }}">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
    <div class="card mt-5">
        <div class="card-header">Contact Details</div>
        <div class="card-body">
            <div class="container" id="fieldList" >
                @forelse($university->universityContacts as $contact)
                <div class="d-flex">
                    <div>
                        <form  action="{{ route('universities.contacts.update',$contact) }}" class="myform" method="POST" id="form_edit_universities_contacts{{$contact->id}}">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="email" class="form-control" name="contact_email" placeholder="Email" required="required" value="{{ $contact->email }}">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="contact_name" placeholder="Name" required="required" value="{{ $contact->name }}">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="contact_designation" placeholder="Designation" required="required" value="{{ $contact->designation }}">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" name="contact_phone" placeholder="Phone" required="required" value="{{$contact->phone}}">
                                </div>
                                <div class="col-md-1">
                                    <div class="d-flex justify-content-around">
                                        <button type="submit" title="Save"  id="save_contact{{$contact->id}}"class="mr-3 btn btn-link"><i class="text-primary fa fa-save fa-lg"></i></button>
                                    </div>
                                </div>  
                            </div>
                        </form>
                    </div>
                    <div>
                        <form  action="{{ route('universities.contacts.destroy',$contact) }}" class="myformDelete" method="POST" id="form_delete_universities_contacts{{$contact->id}}">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" title="Delete" href="" class="btn btn-link"><i class="text-danger fa fa-trash fa-lg"></i></button>
                        </form>
                    </div>
                </div>
                <hr/>
                @empty
                <p id="universities_contact_display_message">No contact yet</p>
                @endforelse
                <div style="display:none !important" class="d-flex" id="contact_form">
                    <div>
                        <form  action="{{ route('universities.contacts.store',$university) }}"  method="POST" id="form_create_universities_contacts">
                            {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="email" id="contact_email" class="form-control" name="email" placeholder="Email" required="required" value="{{ old('email') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="name" placeholder="Name" required="required" value="{{ old('name') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="designation" placeholder="Designation" required="required" value="{{ old('designation') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" name="phone" placeholder="Phone" required="required" value="{{ old('phone') }}">
                                    </div>
                                    <div class="col-md-1">
                                        <div class="d-flex justify-content-around">
                                            <button type="submit" title="Save" class="mr-3 btn btn-link"><i class="text-primary fa fa-save fa-lg"></i></button>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                    <div>
                        <a id="remove" title="Delete" href="#contact_form" onClick="removeContactForm({{sizeof($university->universityContacts)}})" class="btn btn-link"><i class="text-danger fa fa-trash fa-lg"></i></a>
                    </div>
                    <hr/>
                </div>
            </div>         
        </div>
        <div class="card-footer">
            <a href="#contact_form" onClick="addNewContactForm({{old('email')==''?false:true}})">Add More Contact</a>
        </div>
    </div> 
</div>
@endsection



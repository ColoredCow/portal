@extends('hr::layouts.master')
@section('content')
<div class="container" id="project_container">
    <br>
    @include('hr::universities.menu',['active' => 'universities'])
    <br><br>
    <div class="row">
        <div class="col-md-6">
            <h1>Edit University</h1>
        </div>
        <div class="col-md-6">
            <a href="{{ route('universities.create') }}" class="btn btn-success float-right">Add University</a>
        </div>
    </div>
    @include('status', ['errors' => $errors->all()])
    <div class="card">
        <form action="{{ route('universities.update',$university->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-header">
                <span>University Details</span>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="name" class="field-required">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" required="required" value="{{old('name', $university->name)}}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="address" class="field-required">Address</label>
                        <input type="text" class="form-control" name="address" id="address" placeholder="Address" required="required" value="{{old('address', $university->address)}}">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
    <div class="mt-5">

        <h5>University Aliases</h5>
        <div id="update_alias_form_list">
            <div class="d-none alias-clone">
                @include('hr::universities.add-aliases')
            </div>
            @foreach($university->aliases as $alias)
                @include('hr::universities.add-aliases',['alias'=>$alias])
            @endforeach
        </div>
        <div id="create_alias_form_list">
           {{-- For inserting dynamic add alias form --}}
        </div>
        <button type="button" class="btn btn-outline-primary add-aliases mb-3" id="add_contact_btn"><i class="fa fa-plus"></i> Add University Aliases</button>
    </div>

    <div class="mt-5">
        <h5>Contact Details</h5>
        <div id="update_form_list">
            <div class="d-none clone">
                @include('hr::universities.update-contact')
            </div>
            @foreach($university->universityContacts as $contact)
                @include('hr::universities.update-contact',['contact'=>$contact])
            @endforeach
        </div>
        <div id="create_form_list">
           <!--For inserting dynamic add contact form -->
        </div>
        <button type="button" class="btn btn-outline-primary add-contact" id="add_contact_btn"><i class="fa fa-plus"></i> Add new contact</button>
    </div>
</div>
@endsection

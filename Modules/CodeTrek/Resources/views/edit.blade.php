@extends('codetrek::layouts.master')
@section('content')

<div class="container" id="update_details">
    <div  class="card-body">
        <form action="{{route('codetrek.update', $applicant)}}" method="POST" id='updateForm' enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="codetrek" value="applicant->id">
            <div class="card-body">
                <h4 class="mb-3 font-weight-bold">Edit Applicant information</h4>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="first_name" class="field-required">First Name</label>
                            <input type="text" class="form-control" name="first_name" id="firstName" placeholder="Enter first name" required="required" value="{{ $applicant->first_name }}">
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                             <label for="last_name" class="field-required">Last Name</label>
                             <input type="text" class="form-control" name="last_name" id="lastName" placeholder="Enter last name" required="required" value="{{ $applicant->last_name }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                             <label for="email" class="field-required">Email</label>
                             <input type="email" class="form-control" name="email_id" id="email" placeholder="Enter applicant email" required="required" value="{{ $applicant->email }}" readonly>
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                             <label for="phone" >Phone Number</label>
                             <input type="text" class="form-control" name="phone" id="phone_no" placeholder="Enter Phone Number" maxlength="10" value="{{ $applicant->phone }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                             <label for="github_username" class="field-required">Github username</label>
                             <input type="text" class="form-control" name="github_username" id="githubUsername" placeholder="Enter applicant's username" required="required" value="{{ $applicant->github_user_name }}">
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                             <label for="start_date" class="field-required">Start Date</label>
                             <input type="date" class="form-control" name="start_date" id="startDate" required="required" value="{{ $applicant->start_date }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                             <label for="university" >Enter University</label>
                             <input type="text" class="form-control" name="university_name" id="universityName" placeholder="Enter University"  value="{{ $applicant->university }}">
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                             <label for="course" >Course</label>
                             <input type="text" class="form-control" name="course" id="courseName" placeholder="Enter course name" value="{{ $applicant->course }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="graduation" >Graduation Year</label>
                            <select v-model="graduationyear" name="graduation_year" id="graduationYear" class="form-control" >
                                <option value="">Select Graduation Year</option>
                                @php
                                    $currentYear = date('Y');
                                    $endYear = $currentYear + 4;
                                @endphp
                                @for ($i=$endYear; $i>=1990; $i--)
                                <option value="{{$i}}" {{ $applicant->graduation_year == $i ? 'selected' : '' }}>{{$i}} </option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                            <label for="centre" class="field-required">Centre Name</label>
                            <select name="centre" id="centreId" class="form-control" required>
                                <option value="">Select Centre Name</option>
                                @foreach($centres as $centre)
                                    <option value="{{ $centre->id }}" {{ $applicant->centre_id == $centre->id ? 'selected' : '' }}>{{ $centre->centre_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary save-btn">Save</button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirm-delete">Delete</button>
                </div>
        </form>
                @include('component.delete-modal', [
                    'modalId' => 'confirm-delete',
                    'title' => 'Confirm Delete',
                    'body' => 'Are you sure you want to remove this applicant?',
                    'action' => route('codetrek.delete', $applicant)
                    ])
    </div>
</div>
@endsection

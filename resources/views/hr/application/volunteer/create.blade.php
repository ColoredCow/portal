@extends('layouts.app')

@section('content')
<div class="container">
    <h1>New volunteer application</h1>
    <br>

    @include('status', ['errors' => $errors->all()])

    <div class="card">
        <form action="{{route('volunteer.applications.store')}}" method="POST" id="volunteer_form">
            {{ csrf_field() }}
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="name" class="field-required">Job</label>
                            <select class="form-control" name="job_title" id="job_title" value="{{ old('job_title') }}" required="required">
                                <option value="">Select Job</option>
                                @foreach($jobs ?? [] as $job)
                                    <option {{ ($job->title == old('job_title') ? 'selected:selected' : '' ) }} value="{{ $job->title }}">{{ $job->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name" class="field-required">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" required="required" value="{{ old('name') }}">
                        </div>

                        <div class="form-group">
                            <label for="email" class="field-required">Email</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="{{ old('email') }}" required="required">
                        </div>

                        <div class="form-group">
                            <label for="phone" class="field-required">Phone</label>
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone" value="{{ old('phone') }}" required="required">
                        </div>

                    </div>
                    <div class="offset-md-1 col-md-5">
                        <div class="form-group">
                            <label for="phone" class="field-required">Linkedin</label>
                            <input type="text" class="form-control" name="linkedin" id="linkedin" placeholder="Linkedin" value="{{ old('linkedin') }}" required="required">
                        </div>

                        <div class="form-group">
                            <label for="phone" class="field-required">Resume</label>
                            <input type="text" class="form-control" name="resume" id="resume" placeholder="Resume" value="{{ old('resume') }}" required="required">
                        </div>

                        <div class="form-group">
                            <label for="phone" class="field-required">Why do you want to volunteer?</label>
                            <textarea type="text" class="form-control" name="form_data['Why do you want to volunteer?']" placeholder="Why do you want to volunteer?"  required="required" rows="5"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>
@endsection

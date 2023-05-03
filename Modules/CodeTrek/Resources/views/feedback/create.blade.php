@extends('codetrek::layouts.master')
@section('content')
<div class="card">
    <div class="card-header">
        <h3>Applicant Details:</h3>
    </div>
    <div class="form-group col-md-5">
        <label class="text-secondary fz-14 leading-none mb-0.16">Name: {{ $CodeTrekApplicant->first_name }} {{ $CodeTrekApplicant->last_name }}</label>
    </div>
    <div class="form-group col-md-5">
        <label class="text-secondary fz-14 leading-none mb-0.16">Phone: {{ $CodeTrekApplicant->phone }}</label>
    </div>
    <div class="form-row">
        <div class="form-group col-md-5">
            <label class="text-secondary fz-14 leading-none mb-0.16">Email: {{ $CodeTrekApplicant->email }}</label>
        </div>
        <div class="form-group offset-md-1 col-md-5">
            <label class="text-secondary fz-14 leading-none mb-0.16">University: {{ $CodeTrekApplicant->university }}</label>
        </div>
    </div>
    <div class="card-footer">
        <form method="POST" action="{{ route('feedback.storeFeedback') }}">
            <select class ="form-control" id="category" name="category">
                <option value="">Categories</option>
                <option value="discipline">Discipline</option>
                <option value="punctuality">Punctuality</option>
                <option value="performance">Performance</option>
                <option value="communication">Communication</option>
            </select>
            
            @csrf

            <input type="hidden" name="applicant_id" value="{{ $CodeTrekApplicant->id }}">

            <div class="form-group">
                <label for="feedback">Feedback</label>
                <textarea class="form-control" id="feedback" name="feedback" rows="5"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit Feedback</button>
        </form>
    </div>
</div>
@endsection

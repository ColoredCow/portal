@extends('layouts.app')

@section('content')
<div class="container pb-8">
    <br>
    @php
        $menu = 'hr.menu';
        $formAction = route('recruitment.opportunities.store');
        // if ($job->type == 'volunteer') {
            // $menu = 'hr.volunteers.menu';
            // $formAction = route('volunteer.opportunities.store', $job->id);
        // }
    @endphp
    @include($menu)
    <br><br>
    @include('status', ['errors' => $errors->all()])
    <h2 class="mb-3">New Opportunity</h2>
    <form action="{{ $formAction }}" method="POST">
        @csrf
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Details</h5>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-6 form-group">
                        <label for="title" class="fz-14 leading-none text-secondary mb-1">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter job title..." value="{{ old('title') }}" autofocus required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="title" class="fz-14 leading-none text-secondary mb-1">Status</label>
                        <select class="form-control" name="status" id="status" value="{{ old('status') }}">
                            @foreach (config('hr.opportunities-status') as $status => $label)
                                <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="title" class="fz-14 leading-none text-secondary mb-1">Type</label>
                        <select class="form-control" name="type" id="type" value="{{ old('type') }}">
                            <option value="job" {{ old('type') == 'job' ? 'selected' : '' }}>Job</option>
                            <option value="internship" {{ old('type') == 'internship' ? 'selected' : '' }}>Internship</option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="domain" class="fz-14 leading-none text-secondary mb-1">Domain</label>
                        <select class="form-control" name="domain" id="domain" value="{{ old('domain') }}" required>
                            @foreach (config('hr.opportunities.domains') as $domain => $label)
                                <option value="{{ $domain }}" {{ old('domain') == $domain ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="fz-14 leading-none text-secondary mb-1">Description</label>
                    <textarea id="description" class="form-control richeditor" name="description" rows="4" placeholder="Enter job description...">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Interviewers</h5>
            </div>
            <div class="card-body">
                <div class="form-row">
                    @foreach ($rounds as $key => $round)
                        <div class="form-group col-md-5 {{ $key%2 ? 'offset-md-1' : '' }}">
                            <label for="round_{{ $round->id }}" class="fz-14 leading-none text-secondary mb-1">{{ $round->name }}</label>
                            <select
                                class="form-control"
                                name="rounds[{{ $round->id }}][hr_round_interviewer_id]"
                                id="round_{{ $round->id }}"
                                value="{{ old("rounds[$round->id][hr_round_interviewer_id]") }}">
                                <option value="">Select interviewer </option>
                                @foreach($interviewers as $interviewer )
                                    @php
                                        $selected = old("rounds[$round->id][hr_round_interviewer_id]") == $interviewer->id ? 'selected="selected"' : '';
                                    @endphp
                                    <option value="{{ $interviewer->id }}" {{ $selected }}>{{ $interviewer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection

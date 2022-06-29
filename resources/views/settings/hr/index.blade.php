@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <h1>Mail Templates</h1>
    <br>
    @include('status', ['errors' => $errors->all()])
    <br>
    @include('settings.hr.applicant-auto-responder')
    @include('settings.hr.applicant-interview-reminder')
    @include('settings.hr.no-show')
    @include('settings.hr.approve')
    @include('settings.hr.offer-letter')
    @include('settings.hr.on-hold')
    <h4 class="mt-5">Mail templates for rounds</h4>
    @foreach ($rounds as $index => $round)
        @foreach ($roundMailTypes as $type)
            @php
                $mailTemplate = $type['label'] . '_mail_template';
            @endphp
            <div class="card mt-4">
                <form action="{{ route('hr.round.update', $round->id) }}" method="POST">

					{{ csrf_field() }}
					{{ method_field('PATCH') }}

					<div class="card-header c-pointer" data-toggle="collapse" data-target="#round_template_{{ $type['label'] }}_{{ $round->id }}" aria-expanded="true" aria-controls="round_template_{{ $type['label'] }}_{{ $round->id }}">
						{{ $round->name }}
						<span class="{{ $type['class'] }}">{{ $type['label'] }}</span>
					</div>
					<div id="round_template_{{ $type['label'] }}_{{ $round->id }}" class="collapse">
						<div class="card-body">
							<div class="form-row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="round_mail_subject">Subject</label>
									<input type="text" name="round_mail_subject" class="form-control" value="{{ $round->{$mailTemplate}['subject'] ?? '' }}">
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="round_mail_body">Mail body:</label>
										<textarea name="round_mail_body" rows="10" class="richeditor form-control" placeholder="Body">{{ $round->{$mailTemplate}['body'] ?? '' }}</textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer">
							<input type="hidden" name="type" value="{{ $type['label'] }}_mail">
							<button type="submit" class="btn btn-primary">Save</button>
						</div>
					</div>
				</form>
			</div>
		@endforeach
	@endforeach
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('settings.menu', ['active' => 'hr'])
    <br><br>
    <h1>Settings</h1>
    <br>
    @include('status', ['errors' => $errors->all()])
    <div class="card">
        <form action="{{ url('/settings/hr/update') }}" method="POST">
            {{ csrf_field() }}

            <div class="card-header c-pointer" data-toggle="collapse" data-target="#applicant_autoresponder" aria-expanded="true" aria-controls="applicant_autoresponder">Auto responder mail to applicant</div>
            <div id="applicant_autoresponder" class="collapse">
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="setting_key[applicant_create_autoresponder_subject]">Subject</label>
                                <input type="text" name="setting_key[applicant_create_autoresponder_subject]" class="form-control" value="{{ isset($settings['applicant_create_autoresponder_subject']->setting_value) ? $settings['applicant_create_autoresponder_subject']->setting_value : '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="setting_key[applicant_create_autoresponder_body]">Mail body:</label>
                                <textarea name="setting_key[applicant_create_autoresponder_body]" rows="10" class="richeditor form-control" placeholder="Body">{{ isset($settings['applicant_create_autoresponder_body']->setting_value) ? $settings['applicant_create_autoresponder_body']->setting_value : '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
    <h4 class="mt-5">Email templates for rounds</h4>
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
                                    <input type="text" name="round_mail_subject" class="form-control" value="{{ $mailTemplate->{$column}['subject'] }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="round_mail_body">Mail body:</label>
                                        <textarea name="round_mail_body" rows="10" class="richeditor form-control" placeholder="Body">{{ $round->{$mailTemplate}['body'] }}</textarea>
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

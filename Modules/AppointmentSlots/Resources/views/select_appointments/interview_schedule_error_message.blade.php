@extends('appointmentslots::layouts.master')

@section('content')

<div>
    <div class="placing-of-content text-center">
        <div class="mx-auto exclamation-icon h-44 w-44">{!! file_get_contents(public_path('icons/exclamation-circle.svg')) !!}</div>
    </div>
    <h1 class="placing-of-content text-center">Page Not found</h1><br>

    <p class="error-message text-center fz-20 leading-25">
        {{__('Looks like your interview is already scheduled. Please check your inbox for confirmation.') }}<br>

        {{__('If you are not able to find the email, please check in your spam folder. If it\'s there, mark it as "Not Spam".') }}<br>
        
        {{__('If you are still facing issues, please write to us at careers@coloredcow.com') }}
    </p>
</div>
@endsection

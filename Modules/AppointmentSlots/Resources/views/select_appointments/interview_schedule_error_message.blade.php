@extends('appointmentslots::layouts.master')

@section('content')

<div>
    <div style = "text-align: center;">
        <svg style = "width:44; height:44; color:#d44950">{!! file_get_contents(public_path('icons/exclamation-circle.svg')) !!}</svg>
    </div>
    <h1 class="error-heading" style ="text-align: center;">Page Not found</h1><br>

    <p class="error-message" style ="text-align: center; font-size: 20px;">
        Looks like your interview is already scheduled. Please check your inbox for confirmation.<br>

        If you are not able to find the email, please check in your spam folder. If it's there, mark it as "Not Spam".<br>
        
        If you are still facing issues, please write to us at careers@coloredcow.com
    </p>
</div>
@endsection

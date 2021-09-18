{{-- @php
    $user = auth()->user('email');
@endphp --}}
{{-- @if(Auth::check()) --}}
{{-- @if($user == auth()->user('email') && $user != null) --}}
@extends('errors.layout')

@section('error_title', '404')

@section('error_message', config('constants.http_response_messages.404'))

{{-- @else
    @section('content')
        <div>
            <div style ="text-align: center;" >{!! file_get_contents(public_path('icons/exclamation-circle.svg')) !!}</div>
            <h1 class="error-heading" style ="text-align: center;">Page Not found</h1><br>
            <p class="error-message" style ="text-align: center; font-size: 20px;">
                Looks like your interview is already scheduled. Please check your inbox for confirmation.<br>

                If you are not able to find the email, please check in your spam folder. If it's there, mark it as "Not Spam".<br>
                    
                If you are still facing issues, please write to us at careers@coloredcow.com
            </p>
        </div>
    @endsection
@endif --}}
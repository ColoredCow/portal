@extends('errors.layout')

@section('error_title', '404')

@section('error_message', config('constants.http_response_messages.404'))

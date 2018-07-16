@extends('errors::layout')

@section('error_title', '503')

@section('error_message', config('constants.http_response_messages.503'))

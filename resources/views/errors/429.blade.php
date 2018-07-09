@extends('errors::layout')

@section('error_title', '429')

@section('error_message', config('constants.http_response_messages.429'))

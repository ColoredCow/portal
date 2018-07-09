@extends('errors.layout')

@section('error_title', '403')

@section('error_message', config('constants.http_response_messages.403'))

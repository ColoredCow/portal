@extends('infrastructure::layouts.master')

@section('content')
<div class="container">
    @if(auth()->user()->can('infrastructure.backups.view'))
        @include('infrastructure::menu_header', ['tab' => 'DataBase Backups'])

        <ul class="mt-5 w-50p list list-group">
            @foreach($storageBuckets as $storageBucket)
                <li class="list-item list-group-item">{{ \Str::title($storageBucket['Name']) }}</li>
            @endforeach
        </ul>
    @else
        @include('errors.403')
    @endif
</div>
@endsection

@extends('infrastructure::layouts.master')

@section('content')
<div class="container">
   
    @include('infrastructure::menu_header', ['tab' => 'DataBase Backups'])

    <ul class="mt-5 w-50p list list-group">
        @foreach($storageBuckets as $storageBucket) 
            <li class="list-item list-group-item">{{ \Str::title($storageBucket['Name']) }}</li>
        @endforeach
    </ul>
</div>








@endsection

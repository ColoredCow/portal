@extends('infrastructure::layouts.master')

@section('content')
<div class="container">
   
    @include('infrastructure::menu_header', ['tab' => 'DataBase Backups'])

    <ul class="mt-5 w-50 list list-group">
        @foreach($s3buckets as $s3bucket) 
            <li class="list-item list-group-item">{{ \Str::title($s3bucket['Name']) }}</li>
        @endforeach
    </ul>
</div>








@endsection

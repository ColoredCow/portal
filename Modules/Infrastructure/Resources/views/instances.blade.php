@extends('infrastructure::layouts.master')

@section('content')
<div class="container">
    @if(auth()->user()->can('infrastructure.ec2-instances.view'))
        @include('infrastructure::menu_header', ['tab' => 'EC2 Instances'])

        <ul class="mt-5 w-50p list list-group">
            @foreach($instances as $instance)
            <li class="list-item list-group-item">{{ \Str::title($instance['Instances'][0]['Tags'][0]['Value']) }}</li>
            @endforeach
        </ul>
    @else
        @include('errors.403')  
    @endif  
</div>
@endsection

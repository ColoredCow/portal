@extends('infrastructure::layouts.master')

@section('content')
<div class="container">
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-item nav-link font-weight-bold ml-0 pl-2 " href="{{ route('infrastructure.index') }}"><i
                    class="fa fa-users"></i>&nbsp;DataBase Backups</a>
        </li>

        <li class="nav-item">
            <a class="nav-item nav-link font-weight-bold active" href="{{ route('infrastructure.ec2') }}"><i
                    class="fa fa-users"></i>&nbsp;EC2 Instances</a>
        </li>
    </ul>



    <ul class="mt-5 w-50 list list-group">
        @foreach($instances as $instance)
        <li class="list-item list-group-item">{{ \Str::title($instance['Instances'][0]['Tags'][0]['Value']) }}</li>
        @endforeach

    </ul>


</div>








@endsection
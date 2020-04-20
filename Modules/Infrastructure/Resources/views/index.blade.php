@extends('infrastructure::layouts.master')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-item nav-link font-weight-bold ml-0 pl-2 active" href="{{ route('infrastructure.index') }}"><i class="fa fa-users"></i>&nbsp;DataBase Backups</a>
            </li>

            <li class="nav-item">
                <a class="nav-item nav-link font-weight-bold" href="{{ route('infrastructure.ec2') }}"><i class="fa fa-users"></i>&nbsp;EC2 Instances</a>
            </li>

            {{-- <li class="nav-item">
                <a class="nav-item nav-link font-weight-bold" href="{{ route('infrastructure.billing-details') }}"><i class="fa fa-users"></i>&nbsp;Billing details</a>
            </li> --}}
        </ul>

        <div>
            <a target="_blank" href="https://ap-south-1.console.aws.amazon.com/console" class="btn btn-info text-white">Go to AWS console</a>
        </div>
    </div>


    <ul class="mt-5 w-50 list list-group">
        @foreach($s3buckets as $s3bucket) 
            <li class="list-item list-group-item">{{ \Str::title($s3bucket['Name']) }}</li>
        @endforeach

    </ul>


</div>








@endsection

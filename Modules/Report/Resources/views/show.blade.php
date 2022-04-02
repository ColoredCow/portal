@extends('report::layouts.master')
@section('content')
<div class="container">
    <br>
    <div>
        <h4 class="font-weight-bold">{{$report->name}}</h4>
        <div>
            <h4 class="font-weight-bold">Description</h4>
            <div>{{$report->description}}</div>
        </div>
    </div>
    <iframe width="100%" height="900" src="https://datastudio.google.com/embed/reporting/7d875374-261f-4f61-a9e5-4b632417d227/page/Js2hC" frameborder="0" style="border:0" allowfullscreen class="mt-3"></iframe>
</div>
@endsection
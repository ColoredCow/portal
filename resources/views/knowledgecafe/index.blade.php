@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <div class="d-flex justify-content-start row flex-wrap">
    	<div class="col-md-3 card mx-5 my-3">
            <a class="card-body no-transition" href="/knowledgecafe/library/books">
                <br><h2 class="text-center">Library</h2><br>
            </a>
        </div>

        
        <div class="col-md-3 card mx-5 my-3">
            <a class="card-body no-transition" href="/knowledgecafe/weeklydoses/">
            	<br><h2 class="text-center">WeeklyDose</h2><br>
            </a>
        </div>
    </div>

</div>
@endsection


<!-- 
@can('weeklydoses.view')
<div class="col-md-3 card mx-5 my-3">
    <a class="card-body no-transition" href="/weeklydoses/">
        <br><h2 class="text-center">WeeklyDose</h2><br>
    </a>
</div>
@endcan -->
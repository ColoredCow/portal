@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-start row flex-wrap">
    <br>
    <?php foreach ($data['prospectes'] as $prospectes) : ?>
        <div class="col-md-4">
            <div class="card h-75 mx-4 mt-3 mb-5 ">
                <a class="card-body no-transition">
            	   <br><h2 class="text-center">{{ $prospectes->name; }}</h2><br>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>
@endsection

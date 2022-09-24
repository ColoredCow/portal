@extends('hr::layouts.master')
@section('content')
<div class="container">
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <th><strong>Resume</strong></th>
            <th><strong>Desired Resume for {{ $data->pluck('title')->first() }}</strong></th>
        </thead>
        @foreach ($data as $datas)
        <tr>
            <td><a href="{{ $datas->resume }}" target="_blank"><i class="fa fa-file"> {{ $datas->name }} </i></a></td>
            <td>{{ $datas->value }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
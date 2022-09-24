@extends('hr::layouts.master')
@section('content')
    <div class="container">
        <div>
            <h2 class="text-primary">
                Desired Resume for {{ $data->pluck('title')->first() }}
            </h2>
        </div>
        <br><br>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <th><strong>Resume</strong></th>
                <th><strong>Reasons for desirability</strong></th>
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

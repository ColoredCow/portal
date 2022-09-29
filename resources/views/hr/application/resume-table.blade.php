@extends('hr::layouts.master')
@section('content')
    <div class="container">
        <div>
            <h2 class="text-primary">
                Desired Resume for {{ $applicationData->pluck('title')->first() }}
            </h2>
        </div>
        <br><br>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <th><strong>Resume</strong></th>
                <th><strong>Reasons for desirability</strong></th>
            </thead>
            @foreach ($applicationData as $data)
                <tr>
                    <td><a href="{{ $data->resume }}" target="_blank"><i class="fa fa-file"> {{ $data->name }} </i></a></td>
                    <td>{{ $data->value }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection

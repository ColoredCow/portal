@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <h2 class="text-primary">
                Desired Resume for {{ $title }}
            </h2>
        </div>
        <br><br>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <th><strong>Resume</strong></th>
                <th><strong>Reasons for desirability</strong></th>
                <th><strong>Actions</strong></th>
            </thead>
            @foreach ($applicationData as $data)
                <tr>
                    <td><a href="{{ $data->resume }}" target="_blank"><i class="fa fa-file"> {{ $data->name }} </i></a></td>
                    <td>{{ $data->value }}</td>
                    <td>
                            <ul class="nav justify-content-center">
                                <li class="nav-item">
                                    <a href="" class="btn btn-edit" aria-hidden="true" data-toggle="modal"
                                        data-target="#editReason{{$data->id , $data->value , $data->hr_job_id}}"><i class="text-success fa fa-edit fa-lga"></i></a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{route('response.unflag', [$data->id, $data->hr_job_id])}}" class="btn btn-edit">
                                        <i class="text-danger fa fa-trash fa-lg" aria-hidden="true"></i>
                                </a>
                                </li>
                            </ul>
                        
                    </td>
                </tr>
                @include('hr.application.edit-reason')
            @endforeach
        </table>
    </div>
@endsection

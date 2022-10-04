{{-- @extends('hr::layouts.master') --}}
@extends('layouts.app')

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
                <th><strong>Actions</strong></th>
            </thead>
            @foreach ($applicationData as $data)
                <tr>
                    <td><a href="{{ $data->resume }}" target="_blank"><i class="fa fa-file"> {{ $data->name }} </i></a></td>
                    <td>{{ $data->value }}</td>
                    {{-- <td>
                        <form class="d-flex" action="" method="">
                            @csrf
                            @method('DELETE') --}}
                            {{-- <a href="{{route('undesired.resume' , [str_slug($data->title), $data->id])}}" title="Edit" class="pr-1 btn btn-link"><i class="text-success fa fa-edit fa-lg"></i></a> --}}
                             {{-- <a href="#" aria-hidden="true" title="Edit" data-toggle="modal" data-target="#responseModal" class="pr-1 btn btn-link"><i class="text-success fa fa-edit fa-lg"></i></a>
                            <button type="submit" class="pl-1 btn btn-link" title="Delete"><i class="text-danger fa fa-trash fa-lg"></i></button>
                        </form>
                    </td> --}}
                    <td>
                            <ul class="nav justify-content-center">
                                <li class="nav-item">
                                    <a href="" class="btn btn-edit" aria-hidden="true" data-toggle="modal"
                                        data-target="#editReason{{$data->hr_job_id}}"><i class="text-success fa fa-edit fa-lga"></i></a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{route('response.unflag',$data->id)}}" class="btn btn-edit">
                                        <i class="text-danger fa fa-trash fa-lg" aria-hidden="true"></i>
                                </a>
                                </li>
                            </ul>
                        
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    @include('hr.application.edit-reason')
@endsection

@extends('layouts.app')
@section('content')
<div class="container">
  <div>
    <h1>Work History</h1>
  </div>
  <div>
    <table class="table table-bordered table-striped   bg-white text-dark w-full">
      <thead class="bg-secondary text-white text-center  align-middle ">
        <tr>
          <th class="align-middle w-25" rowspan="2" scope="col">Projects</th>
          <th class="align-middle w-50" rowspan="2" scope="col">Clients</th>
          <th class="align-middle w-50" colspan="4" scope="col">TechStack</th>
        </tr>
        <tr>
          <th class="w-25">Language</th>
          <th class="w-25">Framework</th>
          <th class="w-25">Database</th>
          <th class="w-25">Hosting</th>
        </tr>
      </thead>
      <tbody>
        @foreach($employeesDetails as $details)
        @php
          $data=$details->project;
          $projectmeta= $data->meta->pluck('value', 'key');
          $value='Not_Available';
        @endphp
        <tr>
          <td class="text-center "><a href="{{route('project.edit', $details->project  )}}">{{ $data['name']}}</a></td>
          <td class="text-center ">{{ $data->client['name'] }}</td>
          @if(!count($projectmeta)==0)
          <td class="text-center"> {{$projectmeta['language'] ?? $value}}</td>
          <td class="text-center"> {{$projectmeta['database'] ?? $value}}</td>
          <td class="text-center"> {{$projectmeta['framework'] ?? $value}}</td>
          <td class="text-center"> {{$projectmeta['hosting'] ?? $value}}</td>
          @else
          <td class="text-center" colspan="4">{{$value}}</td>
          @endif
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection

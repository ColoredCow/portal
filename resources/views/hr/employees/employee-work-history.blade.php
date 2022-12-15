@extends('layouts.app')
@section('content')
<div class="container" >
    <div><h1>Work History</h1></div>
    <div>
  <table class="table table-bordered table-striped   bg-white text-dark w-full">
  <thead class="bg-secondary text-white text-center  align-middle "style="width:1%">
    <tr>
      <th class="align-middle w-25"  rowspan="2" scope="col">Projects</th>
      <th class="align-middle w-50"  rowspan="2" scope="col">Clients</th>
      <th class="align-middle w-50"  colspan="4" scope="col">TechStacks</th>
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
    <tr>
      <td class="text-center "><a href="{{route('project.edit', $details->project  )}}">{{ $details->project['name'] }}</a></td>   
      <td class="text-center ">{{ $details->project->client['name'] }}</td>
      @php 
      $meta = $details->project->meta->pluck('value', 'key')
      @endphp
      @if(!count($meta)==0)
        <td class="text-center"> {{$meta['language'] ?? 'Not Avaliable'}}</td>
        <td class="text-center"> {{$meta['database'] ?? 'Not Avaliable'}}</td>
        <td class="text-center"> {{$meta['framework'] ?? 'Not Avaliable'}}</td>
        <td class="text-center"> {{$meta['hosting'] ?? 'Not Avaliable'}}</td>
      @else
      <td class="text-center" colspan="4">Not Avaliable</td>
      @endif
    </tr>
    @endforeach
  </tbody>
</table>	   
</div>
</div>   
@endsection

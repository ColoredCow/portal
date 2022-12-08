@extends('layouts.app')
@section('content')

<div class="container">

    <div><h1>Work History</h1></div>
    <div class="container">
  <table class="table table-bordered justify-content-center m-5">
  <thead>
    <tr>
      <th class="text-center" scope="col">Projects</th>
      <th class="text-center" scope="col">Clients</th>
      <th class="text-center" scope="col">TechStacks</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($employees_project_client as $project_client)      
    <tr>
      <td class="text-center">{{ $project_client->project->name }}</td>
      <td class="text-center">{{ $project_client->project->client->name }}</td>
      <td class="text-center"></td>
    </tr>
    @endforeach

  
  </tbody>
</table>	   
</div>

</div>    
@endsection

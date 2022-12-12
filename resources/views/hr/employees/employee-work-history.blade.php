@extends('layouts.app')
@section('content')
<div class="container">
    <div><h1>Work History</h1></div>
    <div class="container">
  <table class="table table-bordered justify-content-center m-5 p-3 mb-2 bg-white text-dark">
  <thead class="bg-secondary text-white">
    <tr>
      <th class="text-center " scope="col">Projects</th>
      <th class="text-center" scope="col">Clients</th>
      <th class="text-center" scope="col">TechStacks</th>
    </tr>
  </thead>
  <tbody>
    @foreach($employeesDetails as $details)
    <tr>
      <td class="text-center"><a href="{{route('project.edit', $details->project  )}}">{{ $details->project['name'] }}</a></td>    
      <td class="text-center">{{ $details->project->client['name'] }}</td>
      <td class="text-center ">
          @foreach ($allTechStacks[$details["project_id"]] as $TechStacks )
            <div class="row col align-self-center "> 
              @forelse($TechStacks as $tech)
              <div class="ml-3 col col-lg-2">  
                <p>{{ $tech }}</p>
              </div>  
              @empty
                <p class=" col-12">Not Avaliable</p>
              @endforelse
            </div>
          @endforeach    
      </td>
    </tr>
    @endforeach
  </tbody>
</table>	   
</div>
</div>   
@endsection

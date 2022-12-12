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
    @foreach($employeesDetails as $details)
    <tr>
      <td class="text-center"><a href="{{route('project.edit', $details->project  )}}">{{ $details->project['name'] }}</a></td>    
      <td class="text-center">{{ $details->project->client['name'] }}</td>
      <td class="text-center  ">
          @foreach ($allTechStacks[$details["project_id"]] as $TechStacks )
            <div class="row "> 
              @forelse($TechStacks as $tech)
              <div class="ml-3 col-2">  
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

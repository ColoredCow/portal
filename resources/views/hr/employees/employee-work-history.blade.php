@extends('layouts.app')
@section('content')
<div class="container">
    <div><h1>Work History</h1></div>
    <div class="container">
  <table class="table table-bordered justify-content-center m-5 p-3 mb-2 bg-white text-dark">
  <thead class="bg-secondary text-white  align-self-center text-center">
    <tr>
      <th class=" text-center align-middle" rowspan="2" scope="col">Projects</th>
      <th class="text-center align-middle" rowspan="2" scope="col">Clients</th>
      <th class="text-center align-middle" colspan="4"scope="col">TechStacks</th>
    </tr>
    <tr>
      <th>Language</th>
      <th>Framework</th>
      <th>Database</th>
      <th>Hosting</th>
    </tr>
  </thead>
  <tbody>
    @foreach($employeesDetails as $details)
    <tr>
      <td class="text-center"><a href="{{route('project.edit', $details->project  )}}">{{ $details->project['name'] }}</a></td>   
      <td class="text-center">{{ $details->project->client['name'] }}</td>
        @foreach ($allTechStacks[$details["project_id"]] as $TechStacks )
           @if (empty($TechStacks))
               <span class="text-center">Not Avaliable</span>
           @else
              @foreach($TechStacks as $tech)
                @if ($tech['value'])
                  <td class="text-center">{{ $tech['value'] }}</td>
                @else
                <td class="text-center">Not Avaliable</td>
                @endif
              @endforeach
            @endif
        @endforeach
    </tr>
    @endforeach
  </tbody>
</table>	   
</div>
</div>   
@endsection

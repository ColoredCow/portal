@extends('layouts.app')
@section('content')

@php
  
@endphp 

    <div class="container">
        <br>
        <h1>Project Contract Report</h1>
        <br><br>
       
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr class="sticky-top">
                    <th>Client Name: </th>
                    <th>Project Name</th>
                    <th>Contract</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($clientDetail as $clientData)
                @php
                        $firstProject = true;
                    @endphp
                    @foreach ($clientData->projects as $project) 
                    @php
                         $endDate = optional($project->end_date);
                         $endDateDiff = $endDate ? $endDate->diffInDays(now()) : null;
                         
                         $endDateAlert = $endDateDiff !== null && $endDateDiff < 7;
                         $endDatePassed = $endDate && $endDate->isPast();
                         
                     @endphp
                        <tr >
                            @if ($firstProject)
                            <td rowspan="{{ count($clientData->projects) }}"><a href="{{route('client.edit', $project->client->id)}}">{{ $clientData->name }}</a></td>
                                @php
                                    $firstProject = false;
                                @endphp
                            @endif
                            <td> <a href="{{ route('project.show', $project) }}">{{ $project->name }}</a></td>
                            <td>
                                @if($project->projectContracts->first())
                                <a href="{{ route('pdf.show', $project->projectContracts->first()) }}">
                                    {{ str_limit(basename($project->projectContracts->first()->contract_file_path),8) }}
                                </a>
                                @else
                                <span class="text-danger">No Contract</span>
                            @endif
                            </td>
                            <td><span class="text-capitalize fz-lg-22">{{ optional($project->start_date)->format('d M Y') ?? '-'}}</span></td>
                            <td @if ($endDatePassed) class="text-danger" @endif>
                                <span class="text-capitalize fz-lg-22  {{ $endDateAlert  }}">
                                    {{ optional($endDate)->format('d M Y') ?? '-' }}
                                    @if ($endDateAlert && !$endDatePassed)
                                    <i class="fa fa-exclamation-triangle ml-4 text-danger " aria-hidden="true" ></i>
                                    @endif
                                </span>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
            
        </table>
    </div>
@endsection

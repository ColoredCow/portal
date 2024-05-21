@extends('layouts.app')
@section('content')
    <div class="container">
        <br>
        <h1>Project Contract Report</h1>
        <br><br>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr class="sticky-top">
                    <th class="w-25p">Client Name: </th>
                    <th class="w-25p">Project Name</th>
                    <th>Contract</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($clientsData as $clientData)
                    @php
                        $totalProjects = count($clientData->projects);
                    @endphp
                    @foreach ($clientData->projects as $key => $project)
                        @php
                        $contractType = $clientData->meta->first()->value ?? 'project';
                        $isClientContract = $contractType === 'client';
                        $contract = $isClientContract ? $clientData->clientContracts->first() : $project;
                        $endDate = $isClientContract ? $contract->end_date : $project->end_date;
                        $endDateDiff = $endDate ? $endDate->diffInDays(now()) : null;
                        $endDateAlert = $endDateDiff !== null && $endDateDiff < $contractEndDateThreshold;
                        $endDatePassed = $endDate && $endDate->isPast();
                        $isLastProject = $key === $totalProjects - 1;
                        @endphp
                        <tr>
                            @if ($key === 0)
                                <td style="border-bottom: 1px solid black; vertical-align: middle;" rowspan="{{ $totalProjects }}">
                                    <a href="{{ route('client.edit', [$project->client->id, 'billing-details']) }}">{{ $clientData->name }}</a>
                                </td>
                            @endif
                            <td style="border-bottom: {{ $isLastProject ? '1px solid black' : 'none' }}">
                                <a href="{{ route('project.edit', $project) }}">{{ $project->name }}</a>
                            </td>

                            @php
                                $contractType = $clientData->meta->first()->value ?? 'project';
                            @endphp

                            @if ($contractType === 'client')
                                @if ($key === 0)
                                    <td style="border-bottom: 1px solid black; vertical-align: middle;" rowspan="{{ $totalProjects }}">
                                        @if ($clientData->clientContracts->first())
                                            <a href="{{ route('client.pdf.show', $clientData->clientContracts->first()) }}" target="_blank">
                                                {{ str_limit(basename($clientData->clientContracts->first()->contract_file_path), 8) }}
                                            </a>
                                        @else
                                            <span class="text-danger">No Contract</span>
                                        @endif
                                @endif
                                </td>
                            @else
                                <td style="border-bottom: {{ $isLastProject ? '1px solid black' : 'none' }}">
                                    @if ($project->projectContracts->first())
                                        <a href="{{ route('pdf.show', $project->projectContracts->first()) }}"
                                            target="_blank">
                                            {{ str_limit(basename($project->projectContracts->first()->contract_file_path), 8) }}
                                        </a>
                                    @else
                                        <span class="text-danger">No Contract</span>
                                    @endif
                                </td>
                            @endif
                            @if ($contractType === 'client')
                                @if ($key === 0)
                                    <td style="border-bottom: 1px solid black; vertical-align: middle;" rowspan="{{ $totalProjects }}">
                                        <span class="text-capitalize fz-lg-17">
                                            {{ $clientData->clientContracts->first()->start_date->format('d M Y') ?? '-' }}
                                        </span>
                                    </td>
                                @endif
                            @else
                                <td style="border-bottom: {{ $isLastProject ? '1px solid black' : 'none' }}">
                                    <span class="text-capitalize fz-lg-17">
                                        {{ optional($project->start_date)->format('d M Y') ?? '-' }}
                                    </span>
                                </td>
                            @endif

                            @if ($contractType === 'client')
                                @if ($key === 0)
                                    <td  style="border-bottom: 1px solid black; vertical-align: middle;" rowspan="{{ $totalProjects }}"
                                        @if ($endDatePassed) class="text-danger" @endif>
                                        <span class="text-capitalize fz-lg-17 {{ $endDateAlert }}">
                                            {{ optional($endDate)->format('d M Y') ?? '-' }}
                                            @if ($endDateAlert && !$endDatePassed)
                                                <i class="fa fa-exclamation-triangle ml-4 toolpit text-theme-orange"
                                                    aria-hidden="true"
                                                    title="This is about to expire in {{ $endDateDiff }} days"></i>
                                            @endif
                                        </span>
                                    </td>
                                @endif
                            @else
                                <td style="border-bottom: {{ $isLastProject ? '1px solid black' : 'none' }}"
                                    @if ($endDatePassed) class="text-danger" @endif>
                                    <span class="text-capitalize fz-lg-17 {{ $endDateAlert }}">
                                        {{ optional($endDate)->format('d M Y') ?? '-' }}
                                        @if ($endDateAlert && !$endDatePassed)
                                            <i class="fa fa-exclamation-triangle ml-4 toolpit text-theme-orange"
                                                aria-hidden="true"
                                                title="This is about to expire in {{ $endDateDiff }} days"></i>
                                        @endif
                                    </span>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

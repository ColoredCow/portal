@extends('layouts.app')
@section('content')
<div class="container">
        <h1>Project Contract</h1>
        <br><br>
        <ul class="nav nav-pills">
            @php
                $request = request()->all();
            @endphp
            <li class="nav-item">
                @php
                    $allContractsRequest = $request;
                    unset($allContractsRequest['status']);
                @endphp
                <a class="nav-link {{ request()->input('status', false) === false ? 'active' : '' }}" href="{{ route('report.project.contracts.index', $allContractsRequest) }}">All Contracts</a>
            </li>
            <li class="nav-item mr-3">
                @php
                    $activeRequest = array_merge($request, ['status' => 'active']);
                @endphp
                <a class="nav-link {{ request()->input('status') == 'active' ? 'active' : '' }}" href="{{ route('report.project.contracts.index', $activeRequest) }}">Active Contracts</a>
            </li>
            <li class="nav-item">
                @php
                    $inactiveRequest = array_merge($request, ['status' => 'inactive']);
                @endphp
                <a class="nav-link {{ request()->input('status') == 'inactive' ? 'active' : '' }}" href="{{ route('report.project.contracts.index', $inactiveRequest) }}">Inactive Contracts</a>
            </li>

        </ul>

        <br>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr class="sticky-top">
                    <th class="w-25p">
                        <a class="text-white text-decoration-none" href="{{ route('report.project.contracts.index', array_merge($request, ['sort' => 'name', 'direction' => request()->get('direction', 'asc') === 'asc' ? 'desc' : 'asc'])) }}">
                            Client Name
                            @if (request()->get('sort') === 'name')
                                <i class="fa fa-sort-{{ request()->get('direction', 'asc') }}"></i>
                            @else
                            <i class="fa fa-sort"></i>
                            @endif
                        </a>
                    </th>
                    <th class="w-25p">Project Name</th>
                    <th>Contract</th>
                    <th>Start Date</th>
                    <th>
                        <a class="text-white text-decoration-none" href="{{ route('report.project.contracts.index', array_merge($request, ['sort' => 'date', 'direction' => request()->get('direction', 'asc') === 'asc' ? 'desc' : 'asc'])) }}">
                            End Date
                            @if (request()->get('sort') === 'date')
                                <i class="fa fa-sort-{{ request()->get('direction', 'asc') }}"></i>
                            @else
                            <i class="fa fa-sort"></i>
                            @endif
                        </a>
                    </th>
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
                                    <a href="{{ route('client.edit', [$project->client->id, 'client-details']) }}" data-toggle="tooltip" title="{{ $clientData->name }}">{{ str_limit($clientData->name, 23) }}</a>
                                </td>
                            @endif
                            <td style="border-bottom: {{ $isLastProject ? '1px solid black' : 'none' }}">
                                @if($project->status === 'active')
                                <a href="{{ route('project.show', $project) }}" data-toggle="tooltip" title="{{ $project->name }}">{{ $project->name }}</a>
                                @else
                                <a class="text-danger" href="{{ route('project.show', $project) }}" data-toggle="tooltip" title="{{ $project->name }}">{{ $project->name }}</a>
                                @endif
                            </td>
                            @if ($contractType === 'client')
                                @if ($key === 0)
                                    <td style="border-bottom: 1px solid black; vertical-align: middle;" rowspan="{{ $totalProjects }}">
                                        @if ($clientData->clientContracts->first())
                                            <a href="{{ route('client.pdf.show', $clientData->clientContracts->first()) }}" target="_blank">
                                                <span data-toggle="tooltip" data-placement="right" title= "{{basename($clientData->clientContracts->first()->contract_file_path)}}">{{ str_limit(basename($clientData->clientContracts->first()->contract_file_path), 10) }}</span>
                                            </a>
                                        @else
                                            <span class="text-danger">No Contract</span>
                                        @endif
                                    </td>
                                @endif
                            @else
                                <td style="border-bottom: {{ $isLastProject ? '1px solid black' : 'none' }}">
                                    @if ($project->projectContracts->first())
                                        <a href="{{ route('pdf.show', $project->projectContracts->first()) }}" target="_blank">
                                           <span data-toggle="tooltip" data-placement="right" title= "{{basename($project->projectContracts->first()->contract_file_path)}}"> {{ str_limit(basename($project->projectContracts->first()->contract_file_path), 10) }} </span>
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
                                            {{ optional($clientData->clientContracts->first()->start_date)->format('d M Y') ?? '-' }}
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
                                    <td style="border-bottom: 1px solid black; vertical-align: middle;" rowspan="{{ $totalProjects }}"
                                        @if ($endDatePassed) class="text-danger" @endif>
                                        <span class="text-capitalize fz-lg-17 {{ $endDateAlert }}">
                                            {{ optional($endDate)->format('d M Y') ?? '-' }}
                                            @if ($endDateAlert && !$endDatePassed)
                                                <span data-toggle="tooltip" data-placement="right" title="This is about to expire in {{ $endDateDiff }} days"><i class="fa fa-clock-o fa-lg ml-5 toolpit text-theme-orange" aria-hidden="true"></i>
                                                </span>
                                            @endif
                                        </span>
                                    </td>
                                @endif
                            @else
                                <td style="border-bottom: {{ $isLastProject ? '1px solid black' : 'none' }}" @if ($endDatePassed) class="text-danger" @endif>
                                    <span class="text-capitalize fz-lg-17 {{ $endDateAlert }}">
                                        {{ optional($endDate)->format('d M Y') ?? '-' }}
                                        @if ($endDateAlert && !$endDatePassed)
                                            <span data-toggle="tooltip" data-placement="right" title="This is about to expire in {{ $endDateDiff }} days"><i class="fa fa-clock-o fa-lg ml-5 toolpit text-theme-orange" aria-hidden="true"></i>
                                            </span>
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

@can('projects.view')
    @foreach($clients as $client)
        <tr class="bg-theme-warning-lighter">
            <td colspan=4 class="font-weight-bold">
                <div class="d-flex justify-content-between">
                    <div>
                        {{ $client->name }}
                    </div>
                    <div class="">{{ __('Total Hours Booked: ') . $client->current_hours_in_projects }}</div>
                </div>
            </td>
        </tr>
        @foreach($client->projects as $project)
            <tr>
                @can('projects.update')
                    <td class="w-33p"><div class="pl-2 pl-xl-3"><a href="{{ route('project.show', $project) }}">{{ $project->name }}</a></div></td>
                @else
                    <td class="w-33p"><div class="pl-2 pl-xl-3">{{ $project->name }}</div></td>
                @endcan
                <td class="w-20p">
                @foreach($project->getTeamMembers ?:[] as $teamMember)
                    <span class="content tooltip-wrapper"  data-html="true" data-toggle="tooltip"  title="{{ $teamMember->user->name }} - {{ config('project.designation')[$teamMember->designation]}} <br>    Efforts: {{$teamMember->current_actual_effort}} Hours">
                        <a href={{ route('employees.show', $teamMember->user->employee) }}><img src="{{ $teamMember->user->avatar }}" class="w-35 h-30 rounded-circle mb-1 mr-0.5 {{ $teamMember->current_actual_effort >= $teamMember->current_expected_effort ? 'border border-success' : 'border border-danger' }} border-2"></a>
                    </span>
                @endforeach
                </td>
                <td>
                    @if(empty($project->projectContracts->first()->contract_file_path))
                        <span class="badge badge-light border border-dark rounded-0">No Contract</span>
                    @endif
                </td>
                <td class="w-20p">
                    @php
                        $textColor = $project->velocity >= 1 ? 'text-success' : 'text-danger'
                    @endphp
                    <a class="{{ $textColor }}" href="{{route('project.effort-tracking', $project)}}"><i class="mr-0.5 fa fa-external-link-square"></i></a>
                    <span class="{{ $textColor }} font-weight-bold">{{ $project->velocity . ' (' . $project->current_hours_for_month . ' Hrs.)' }}</span>
                </td>
            </tr>
        @endforeach
    @endforeach
@else
    <tr>
        <td colspan="3">
            <p class="my-4 text-left"> You don't have permission to see projects.</p>
        <td>
    </tr>
@endcan

@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('hr.employees.menu')
    <br><br>
    <h1>Employees</h1>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Name</th>
            <th>Designation</th>
            <th>Joined on</th>
            <th>Projects Count</th>
            <th>Current FTE</th>
        </tr>

        @foreach ($employees as $employee)
        <tr>
            <td>
                <a href={{ route('employees.show', $employee->id) }}>{{ $employee->name }}</a>
            </td>
            <td>
                @if ($employee->designation)
                    {{ $employee->designation }}
                @else
                    -
                @endif
            </td>
            <td>
            @if ($employee->joined_on)
                <span>{{$employee->joined_on->format('d M, Y') }}</span>
                <span style="font-size: 10px;">&nbsp;&#9679;&nbsp;</span>
                <span>{{$employee->employmentDuration }}</span>
            @else
                -
            @endif
            </td>
            <td>
                @if($employee->user == null)
                    0
                @else
                    {{count($employee->user->activeProjectTeamMembers)}}
                @endif
            </td>
            <td class="{{ $employee->user ? ($employee->user->fte > 1 ? 'text-success' : 'text-danger') : 'text-secondary'}} font-weight-bold">{{ $employee->user ? $employee->user->fte :'NA' }}</td>
        </tr>
        @endforeach
    </table>
    <ul class="pagination" role="navigation">
        <li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
            <span class="page-link" aria-hidden="true">‹</span>
        </li>
        <li class="page-item active" aria-current="page">
            <span class="page-link">1</span>
        </li>
        <li class="page-item">
            <span class="page-link bg-light">2</span>
        </li>
        <li class="page-item">
            <span class="page-link bg-light">3</span>
        </li>
        <li class="page-item bg-light">
            <span class="page-link" rel="next" aria-label="Next »">›</span>
        </li>
    </ul>
</div>
@endsection

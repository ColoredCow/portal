<div>
    <p>Hi,</p>
    <p>The following applications on {{ config('app.name') }} are scheduled for you today:</p>

    <ul>
    @foreach ($applicationRounds as $applicationRound)
        <li>
            <b>{{ date(config('constants.hr.interview-time-format'), strtotime($applicationRound->scheduled_date)) }} –</b>&nbsp;{{ $applicationRound->round->name }} for {{ $applicationRound->application->applicant->name }}
            @php
                $route = 'applications.' . $applicationRound->application->job->type . '.edit';
            @endphp
            &nbsp;&nbsp;<a href="{{ URL::route($route, $applicationRound->application->id) }}">View</a>
        </li>
    @endforeach
    </ul>
</div>

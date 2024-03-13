<div>
    <p>Hi,</p>
    <p>The following applications on {{ config('app.name') }} are scheduled for you today:</p>

    <ul>
    @foreach ($applicationRounds as $applicationRound)
        <li>
            <b>{{ $applicationRound->scheduled_date->format(config('constants.hr.interview-time-format')) }} –</b>&nbsp;{{ $applicationRound->round->name }} for {{ $applicationRound->application->applicant->name }} (Job role: {{ $applicationRound->application->job->title }})
            @php
                $route = 'applications.' . $applicationRound->application->job->type . '.edit';
            @endphp
            &nbsp;&nbsp;<a href="{{ URL::route($route, $applicationRound->application->id) }}">View</a>
        </li>
    @endforeach
    </ul>
</div>

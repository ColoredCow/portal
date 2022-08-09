<div>
	<p>Hey {{$user->name}},</p>
	<p>Please check with the following applicants, we need to follow up with them via phone call. They have already been sent follow-ups via email. If possible please check with them over a phone call regarding their interview schedules.
    </p>
</div>
@foreach($applications as $application)
    <p>|{{$application->applicant->name ?? "-"}} | {{$application->applicant->phone ?? "-"}}| {{$application->job->title ?? "-"}}</p>
@endforeach

Thanks,<br>
<p>Hr team</p>
<p>Coloredcow.</p> 

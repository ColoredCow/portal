<div>
    <p>Hello {{$user->name}},</p>
    <p>The following applications are present in the portal, which need to follow up on the phone call. Please proceed with the necessary actions:
    </p>
</div>
@foreach($applications as $application)
<p>|{{$application->applicant->name ?? "-"}} | {{$application->applicant->phone ?? "-"}}| {{$application->hr_job ?? "-"}}</p>
@endforeach

Thanks,<br>
<p>HR team</p>
<p>ColoredCow.</p>
<div>
	<p>Hello Pankaj kandpal,</p>
	<p>The following applications are present in the portal, those whose status is not verified. Please follow up with them via phone call
    </p>
</div>
@foreach($applications as $application)
    <p>|{{$application->applicant->name ?? "-"}} | {{$application->applicant->phone ?? "-"}}| {{$application->job->title ?? "-"}}</p>
@endforeach

Thanks,<br>
<p>Hr team</p>
<p>Coloredcow.</p>
<div>
	<p>Hello</p>
	<p>The following applications are present in the portal, those whose followUp attempts are greater than 2. Please follow up with them via phone call
    </p>
</div>
@foreach($applications as $application)
    <p>|{{$application->applicant->name ?? "-"}} | {{$application->applicant->phone ?? "-"}}| {{$application->job->title ?? "-"}}</p>
@endforeach

Thanks,<br>
<p>Hr team</p>
<p>Coloredcow.</p> 

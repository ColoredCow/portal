@php
	$assignee = $application->latestApplicationRound->scheduledPerson;
@endphp
{{-- $jobType = $this->getApplicationType(); --}}
<p>Hey Scheduled {{$assignee->name}}, <br> The |*APPLICATION TYPE*| application of *APPLICANT NAME*|{{$application->name}}| applied for |*JOB ROLE*| is requested for evaluation by {{auth()->user()->name}}. Please click the link to handover the application.: {{$application->name}}</p>
<a href="{{ route('application.handover.confirmation', ['application' => $application->id, 'user' => auth()->user()->id])}}">Handover application</a>
<p>Thanks,<br>HR,<br>Coloredcow</p>
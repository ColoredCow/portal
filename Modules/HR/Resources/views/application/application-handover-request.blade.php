@php
	$assignee = $application->latestApplicationRound->scheduledPerson;
@endphp
<p>Hey Scheduled {{$assignee->name}}, <br> The {{$application->job->type}} application of {{$application->applicant->name}} applied for {{$application->job->title}} is requested for evaluation by {{auth()->user()->name}}. Please click the link to handover the application.: {{$application->name}}</p>
<a href="{{ route('application.handover.confirmation', ['application' => $application->id, 'user' => auth()->user()->id])}}">Handover application</a>
<p>Thanks,<br>HR,<br>Coloredcow</p>
<p>
    Hey {{$application->latestApplicationRound->scheduledPerson->name}}, <br> <br>The {{$application->job->type}} application of {{$application->applicant->name}} applied for {{$application->job->title}} is requested for evaluation by {{$userName}}. Please click the link to handover the application :
</p>
    <a href="{{ route('application.handover.confirmation', ['application' => $application->id, 'user' => auth()->user()->id])}}">Handover application</a>
<p>
    Thanks,<br>HR,<br>Coloredcow
</p>

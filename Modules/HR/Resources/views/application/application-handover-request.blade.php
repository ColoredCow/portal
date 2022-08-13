<p>Hey Scheduled person, <br> Please click the link and handover the application id : {{$application->id}}</p>
<a href="{{ route('application.handover.confirmation', ['application' => $application->id, 'user' => auth()->user()->id])}}">Handover application</a>
<p>Thansks,<br>HR,<br>COloredcow</p>
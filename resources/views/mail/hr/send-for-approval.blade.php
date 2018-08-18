<div>	
	 <p>Hello {{$supervisor->name}}!</p>
	 <p>Offer Letter is pending for Applicant name <b>{{$application->applicant->name}}</b> Who has completed all the round for the Job desiganation <b>{{$application->job->title}}</b></p>
	 <p><a href="{{$application->applicant->offer_letter}}"> click here to find the Offer Letter</a></p>
</div>
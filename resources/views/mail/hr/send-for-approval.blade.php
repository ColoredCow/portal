<div>
	<p>Hello {{ $supervisor->name }}!</p>
	<p>Your approval on an application is pending.</p>
	<ul>
		<li>Applicant name: {{ $application->applicant->name }}</li>
		<li>Applied for: {{ $application->job->title }}</li>
	</ul>
	<a href="{{ route('applications.' . $application->job->type . '.edit', $application->id) }}">Click here</a> to see the application and take action.
</div>

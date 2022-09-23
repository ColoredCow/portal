<div>
	<p>Hello {{ $project->client->keyAccountManager->name }},</p>
	<p>We found some fixed-budget projects which arenot having any end-date. Please update these projects:</p>
	<table class="table">
		<thead>
			<tr>
			<th scope="col">Project Name</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<a href="{{ route('project.show', $project) }}">{{ $project->name }}</a>
				</td>
			</tr>
		</tbody>
		</table>
	<br>
	<p>Thanks,</p> <br>
	<p>Portal Team</p> <br>
	<p>ColoredCow</p>
</div>

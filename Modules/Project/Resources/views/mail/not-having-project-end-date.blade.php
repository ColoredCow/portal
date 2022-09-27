<div>
	<p>Hi, {{ $project->client->keyAccountManager->name }}</p>
	<p>There are some fixed-budget projects which are not having any project end-date where you are assigned as a key account manager, please update these projects:
	</p>
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
	<p>Thanks,</p>
	<p>Portal Team</p>
	<p>ColoredCow</p>
</div>

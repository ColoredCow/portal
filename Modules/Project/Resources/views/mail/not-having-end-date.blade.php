<div>
	<style>
		.line {
			line-height: 1px;
		}
	</style>
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
	<p class="line">Thanks,</p>
	<p class="line">Portal Team</p>
	<p class="line">ColoredCow</p>
</div>

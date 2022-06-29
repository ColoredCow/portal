<div>
	<style>
		.line {
			line-height: 1px;
		}
	</style>
	<p>Hello {{ $projectManager['name'] }},</p>
	<p>We found some projects where the expected hours are zero for you or team members where you are assigned as project manager. Please update these projects:</p>
	<table class="table">
		<thead>
			<tr>
			<th scope="col">Project Name</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($projectManager['projects'] as $project)
				<tr>
					<td>
						<a href="{{ route('project.show', $project) }}">{{ $project->name }}</a>
					</td>
				</tr>
			 @endforeach
		</tbody>
		</table>
	<br>
	<p class="line">Thanks,</p>
	<p class="line">Portal Team</p>
	<p class="line">ColoredCow</p>
</div>

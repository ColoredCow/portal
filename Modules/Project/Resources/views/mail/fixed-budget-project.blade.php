<div>
	<style>
		.line {
			line-height: 1px;
		}
	</style>
	<p>Hi, {{ $projectData[0]['name'] }}</p>
	<p>This is a reminder Email to let you know that, There are some fixed budget projects which are close to completion.Please take a look at the project and updaate or modify accordingly.</p>
	<table class="table">
		<thead>
			<tr>
				<th scope="col-1">Project Name</th>
				<th scope="col-2">Project End Date</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					@foreach ($projectData as $project)
						<li><a href="{{ route('project.show', $project['project']) }}">{{$project['project']->name}}</a></li>
					@endforeach
				</td>
				<td>
					@foreach ($projectData as $project)
					<p>{{$projectData[0]['end date']->todatestring()}}</p>
					@endforeach
				</td>
			</tr>
		</tbody>
	 </table>
	<br>
	<p class="line">Thanks,</p>
	<p class="line">ColoredCow Portal</p>
</div>

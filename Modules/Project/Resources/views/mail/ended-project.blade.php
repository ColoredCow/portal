<div>
	<style>
		.line {
			line-height: 1px;
		}
	</style>
	<p>Hi,
		@foreach ($projectData as $project) 
	    @endforeach
		{{$project['name']}}
	</p>
	 <p>There are some projects that have reached their end date but are still marked as active. We need you to take action so that the team can get clarity on active projects, the team's availability and assign other projects accordingly.</p>
	 <table class="table">
		<thead>
			<tr>
			<th scope="col">Project Name</th>
			</tr>
		</thead>
		<tbody>
				<tr>
					<td>
						@foreach ($projectData as $projects)
						    <li>{{$projects['project']}}</li>
						@endforeach
					</td>
				</tr>
		</tbody>
	 </table>
	<br>
    <p>To view all your projects, you can use this link  <a href="http://portal.test/projects">My Projects</a>.</p>
    <br>
	<p class="line">Thanks,</p>
	<p class="line">ColoredCow Portal</p>
</div>

<div>
	<style>
		.line {
			line-height: 1px;
		}
	</style>
	<p>Hi, {{ $projectDetails['name'] }}</p>
	<p>Some of your expected hour is zero in the following projects so please talk with Key Account Manager regarding this issue.</p>
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Project Name</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<li><a href="{{ route('project.show', $projectDetails['projects']) }}">{{$projectDetails['projects']->name}}</a></li>
				</td>
			</tr>
		</tbody>
	 </table>
	<br>
    <p>To view all your projects, you can use this link  <a href="{{ route('project.index', ['status' => 'active'])  }}">My Projects</a>.</p>
    <br>
	<p class="line">Thank You,</p>
	<p class="line">ColoredCow Portal</p>
</div>


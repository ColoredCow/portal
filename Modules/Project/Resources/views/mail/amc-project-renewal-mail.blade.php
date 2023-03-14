<div>
	<style>
		.line {
			line-height: 1px;
		}
	</style>
	<p>Hi,</p>
	<p>This is a reminder email to let you know that, your project end date is near ,please renew the AMC Project Contract .</p>
	<table class="table">
        <thead>
            <tr>
                <th scope="col">Project Name</th>
			</tr>
		</thead>
		<tbody> 
            <tr>
                <td>
                    @foreach ($data as $data)
						<li><a href="{{ route('project.show', $data->id) }}">{{$data->name}}</a></li>
					@endforeach
				</td>
			</tr>
		</tbody>
	 </table>
	<br>
	<p class="line">Thanks,</p>
	<p class="line">ColoredCow</p>
</div>

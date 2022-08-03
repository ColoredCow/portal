<div>
<p>Hello {{ $users['name'] }},</p>
	<p>We found that your logged efforts are less than your expected efforts. Please update your effort in the following project(s):</p>
	<div class ="table-responsive">
        <table>
            <thead>
                <tr>
                    <th scope="col" class="pb-lg-6">Date</th>
                    <th scope="col" class="pb-lg-6">Project Name</th>
                    <th scope="col" class="pb-lg-6">Hours Booked</th>
                    <th scope="col" class="pb-lg-6">Expected Hours</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach ($users['projects'] as $user)
                    <tr>
                      <td>{{now()}}</td>
                      <td>{{$user['Project']}}</td>
                      <td>{{$user['bookedHours']}}</td>
                      <td>{{$user['expectedHours']}}</td>
                    </tr>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
	<br>

    <p class="line">Thanks,</p>
	<p class="line">Portal Team</p>
	<p class="line">ColoredCow</p>

</div>

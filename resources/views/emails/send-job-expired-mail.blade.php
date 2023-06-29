<div>
    <p>Hi,</p>
    <div>There are few published jobs that are expired. Please mark them close from portal. Here are the list of these jobs.</div>

    @foreach($jobsData as $job)
        <div>{{$loop->iteration}}. {{ $job->title }}</div>
    @endforeach
    <p>Please visit this <a href={{route('recruitment.opportunities')}} >link</a> to update the status of the jobs.</p>
    <br>
    <p>Thanks,</p>
    <p>ColoredCow</p>
</div>


<div>
    <p>Hi,</p>
    <div>There are few published jobs that are expired. Please mark them close from portal. Here are the list of these jobs.</div>

    @foreach($jobs_data as $job)
        <div>{{$loop->iteration}}. {{ $job->title }}</div>
    @endforeach
    <p>Please visit this <a href={{config('app.url').'/hr/recruitment/opportunities'}} >link</a> to update the status of the jobs.</p>
    <br>
    <p>Thanks,</p>
    <p>ColoredCow</p>
</div>


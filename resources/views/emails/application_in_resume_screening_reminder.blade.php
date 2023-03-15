<div>
    <p>Dear HR,</p>
    <br>
    <p>I hope this email finds you well. This is to inform you that there are {{ $count }} applications that are in resume screening for more than 3 days. Please find the details of these applications below:</p>
    <br>
    <ol>
        @foreach ($applications as $application)
            <li><strong>Name -</strong><a href="route(hr/recruitment/applicant/details/show/{{ $application->applicant->id }} )">{{ $application->applicant->name }}</a>
                <br> <strong>Email -</strong> {{ $application->applicant->email }}
                <br> <strong>Phone -</strong> {{ $application->applicant->phone }}
                <br> <strong>Applied on -</strong> {{ \Carbon\Carbon::parse($application->applicant->created_at)->format('j M Y') }}</li>
            <br>
        @endforeach
    </ol>
    <br>
    <p>Thanks,</p>
    <p>ColoredCow</p>
</div>




<div>
    <p>Dear HR,</p>
    <br>
    <p>I hope this email finds you well. This is to inform you that there are {{ $count }} applications that are in resume screening for more than 3 days. Please find the details of these applications below:</p>
    <br>
    <ol>
        @foreach ($applicants as $applicant)
            <li><strong>Name -</strong> {{ $applicant->name }}
                <br> <strong>Email -</strong> {{ $applicant->email }}
                <br> <strong>Phone -</strong> {{ $applicant->phone }}
                <br> <strong>Applied on -</strong> {{ \Carbon\Carbon::parse($applicant->created_at)->format('j M Y') }}</li>
            <br>
        @endforeach
    </ol>
    <br>
    <p>Thanks,</p>
    <p>ColoredCow</p>
</div>




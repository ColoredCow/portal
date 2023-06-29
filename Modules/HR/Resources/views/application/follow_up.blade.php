<div>
    <p>Hello Pankaj Kandpal,</p>
    <p>The following applications are present in the portal, which need to follow up on the phone call. Please proceed with the necessary actions:
    </p>
</div>
@foreach ($followUps as $followUp)
<p>{{ $followUp->applicant_name }} - {{ $followUp->applicant_phone_number }} - {{ $followUp->hr_job }}</p>
@endforeach

Thanks,<br>
<p>HR team</p>
<p>ColoredCow.</p>
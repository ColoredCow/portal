<div>
{!! $applications->mail_body !!}
    <div>
    <ul>
        @if($applications->calendar_event != Null)

        <P>Please click on this to check the calendar event </P>

        <a href= "{{ $applications->calendar_event }}">Calendar Event</a>

        @endif
    </ul>
    </div>
</div>

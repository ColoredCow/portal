<div>
{!! $applications->mail_body !!}
    <div>
        @if($applications->calendar_event != Null)

        <P>Please <a href= "{{ $applications->calendar_event }}">click here</a> to check the calendar event </P>

        @endif
    </div>
</div>

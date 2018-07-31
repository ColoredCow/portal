<div>
{!! $applications->mail_body !!}
    <div>
        @if($applications->calendar_event != Null)

        <p>Please <a href= "{{ $applications->calendar_event }}">click here</a> to check the calendar event </p>

        @endif
    </div>
</div>

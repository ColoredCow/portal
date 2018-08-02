<div>
{!! $applicationRound->mail_body !!}
    <div>
        @if($applicationRound->calendar_event != Null)

        <p>Please <a href= "{{ $applicationRound->calendar_event }}">click here</a> to check the calendar event </p>

        @endif
    </div>
</div>

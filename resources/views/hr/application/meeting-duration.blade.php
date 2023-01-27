<div class="form-group col-md-3">
    <label for="expected_time" class="fz-14 leading-none text-secondary w-100p">
        <div>
            <span>Expected End Time</span>
        </div>
    </label>

    <input type="Text" readonly="readonly" name="expected_time" id="expected_time" class="form-control form-control-sm"
        value=" {{ $applicationRound->ExpectedMeetingDuration }}">
</div>


<div class="form-group col-md-4">
    <label for="actualEndTime" class="fz-14 leading-none text-secondary w-100p">
        <div>
            <span>Meeting Duration</span>
        </div>
    </label>

    <input type="Text" readonly="readonly" name="actualEndTime" id="actual_end_time"
        class="form-control form-control-sm" value=" {{ $applicationRound->ActualMeetingDuration }} ">
</div>

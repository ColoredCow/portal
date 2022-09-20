<!-- <div class="form-group">
    <label class="font-weight-bold" for="">Designation:</label>
    <span>{{ Str::title($user->profile->designation) }}</span>
</div> -->

<div class="form-group">
    <label class="font-weight-bold" for="">Mobile:</label>
    <span>{{ $user->profile->mobile }}</span>
</div>

<div class="form-group">
    <label class="font-weight-bold" for="">Father:</label>
    <span>{{ $user->profile->father_name }}</span>
</div>

<div class="form-group">
    <label class="font-weight-bold" for="">Marital Status:</label>
    <span>{{ $user->profile->marital_status }}</span>
</div>

<!-- <div class="form-group">
    <label class="font-weight-bold" for="">Designation:</label>
    <span>{{ Str::title($user->profile->designation) }}</span>
</div> -->

<div class="form-group">
    <label class="font-weight-bold" for="">Current Location:</label>
    <span>{{ $user->profile->current_location }}</span>
</div>
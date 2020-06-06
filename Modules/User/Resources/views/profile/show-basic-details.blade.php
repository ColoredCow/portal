<div class="text-right">
    <p class="btn btn-info">Edit</p>
</div>

<div class="d-flex mt-4">
    <div class="mr-10">
        <div class="rounded w-200">
            <img class="rounded w-100p" src="{{ $user->avatar }}" alt="">
        </div>
    </div>

    <div>
        <div class="form-group">
            <label class="font-weight-bold" for="">Name:</label>
            <span>{{ $user->name }}</span>
        </div>
        <div class="form-group">
            <label class="font-weight-bold" for="">Email:</label>
            <span>{{ $user->email }}</span>
        </div>

        <div class="form-group">
            <label class="font-weight-bold" for="">Designation:</label>
            <span>{{ Str::title($user->profile->designation) }}</span>
        </div>

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

        <div class="form-group">
            <label class="font-weight-bold" for="">Designation:</label>
            <span>{{ Str::title($user->profile->designation) }}</span>
        </div>

        <div class="form-group">
            <label class="font-weight-bold" for="">Current Location:</label>
            <span>{{ $user->profile->current_location }}</span>
        </div>

    </div>
</div>
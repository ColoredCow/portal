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

      @includeWhen($user->profile, 'user::profile.subviews.show-user-profile-info')

    </div>
</div>
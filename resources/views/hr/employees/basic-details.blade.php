@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('hr.employees.menu')
    <br><br>
    <div class="d-flex justify-content-between">
        <div class="d-flex">
            <div class="rounded w-200 mr-10">
                <img class="rounded w-100p" src="{{ $user->avatar }}" alt="">
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
        <div>
            <button class="btn btn-info">Edit</button>
        </div>
    </div>
</div>
@endsection


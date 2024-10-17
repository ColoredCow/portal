  <!-- Modal -->
<div class="modal fade" id="edit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel"><strong>Edit Profile</strong></h5>
              <button type="button" class="close" data-dismiss="modal"><b>&times;</b></button>
            </div>

            <div class="modal-body">
            <div class="alert alert-danger d-none pr-0.83" id="profile-details-error">
                <button type="button" id="segmentModalCloseBtn" class="float-right bg-transparent text-danger border-0 fz-16 mt-n1.33">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong class="profile-details-error"></strong>
            </div>
            <form  id="editform" action="{{route('profile.update', $user->id)}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required value="{{$user->name}}">
                </div>
                <div class="form-group">
                    <label for="nickName">Nickname</label>
                    <input type="text" class="form-control" id="nickName" name="nickName" required value="{{$user->nickname}}">
                </div>
                <div class="form-group">
                    <label for="date_of_birth">Date of Birth</label>
                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required value="{{$user->profile ? $user->profile->date_of_birth : ''}}">
                </div>
                <div class="form-group">
                    <label for="email">PAN Number</label>
                    <input type="text" class="form-control" id="pan_details" name="pan_details" value="{{$user->pan_details}}">
                </div>
                <div class="form-group">
                    <label for="designation">Designation</label>
                    <select class="form-control" name="designationId">
                        @foreach ($designations as $designation )
                        <option {{$designation['id'] == $user->employee->designation_id ? "selected" : ""}} value="{{ $designation['id'] }}">{{$designation['designation']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" value="{{$user->email}}" readonly>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="">Address:</label>
                    <textarea name="address" id="address" class="richeditor">{{ optional($user->profile)->address }}</textarea>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="">Insurance Tenants:</label>
                    <input type="number" name="insurance_tenants" id="insurance_tenants" value="{{ optional($user->profile)->insurance_tenants }}"></input>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>
@includeWhen(session('success'), 'toast', ['message' => session('success')])
<div class="d-none alert alert-success " id="successMessage" role="alert">
    <strong>Changes Saved Successfully!</strong>
</div>

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
                <label class="font-weight-bold" for="">Nickame:</label>
                <span>{{ $user->nickname }}</span>
            </div>
            @php
                $dateOfBirth = $user->profile->date_of_birth ?? null;
                $formattedDate = '';

                if ($dateOfBirth && $dateOfBirth !== '0000-00-00') {
                    $formattedDate = (new DateTime($dateOfBirth))->format(config('constants.display_date_format'));
                }
            @endphp
            <div class="form-group">
                <label class="font-weight-bold">DOB:</label>
                <span>{{$formattedDate}}</span>
            </div>
            <div class="form-group d-flex">
                <label class="font-weight-bold" for="">PAN No.:</label>
                <span class="ml-2">{!! optional($user->profile)->pan_details !!}</span>
            </div>
            <div class="form-group">
                <label class="font-weight-bold" for="">Designation:</label>
                <span>{{ $user->employee->designation }}</span>
                @foreach ($designations as $designation )
                    <span>{{ $user->employee->designation_id && $user->employee->designation_id == $designation['id'] ? $designation['designation'] : "" }}</span>
                @endforeach
            </div>
            <div class="form-group">
                <label class="font-weight-bold" for="">Domain:</label>
                @foreach ($domains as $domain )
                    <span>{{ $user->employee->designation_id && $user->employee->hrJobDesignation->domain_id == $domain['id'] ? $domain['domain'] : "" }}</span>
                @endforeach
            </div>
            <div class="form-group">
                <label class="font-weight-bold" for="">Email:</label>
                <span>{{ $user->email }}</span>
            </div>
            <div class="form-group d-flex">
                <label class="font-weight-bold" for="">Address:</label>
                <span class="ml-2">{!! optional($user->profile)->address !!}</span>
            </div>
            <div class="form-group">
                <label class="font-weight-bold" for="">Insurance Tenants:</label>
                <span>{{ optional($user->profile)->insurance_tenants }}</span>
            </div>
            
            {{-- @includeWhen($user->profile, 'user::profile.subviews.show-user-profile-info') --}}
        </div>
    </div>
   
    <div class="d-flex">
        @can('user.delete')
            @if($user->deleted_at === null)
                <div>
                    <button class="btn btn-danger mr-3" data-toggle="modal" data-target="#deleteUserModal">Terminate</button>
                </div>
            @else
                <div>
                    <button class="btn btn-danger mr-3 c-not-allowed" disabled>Terminate</button>
                    <div class="text-danger fz-10 mt-0.5 font-weight-bold w-100 leading-10">
                        User is deleted from system
                    </div>
                </div>
            @endif
        @endcan
        <div>
            <button class="btn btn-info" data-toggle="modal" id="editProfileBtn" data-target="#edit">Edit</button>
        </div>
    </div>
    @can('user.delete')
        @if($user->deleted_at === null)
            <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                Delete user: <strong> {{ $user->name }}</strong>
                            </h5>
                        </div>
                        <form action="{{route('user.delete', $user->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="modal-body">
                                <div>
                                    Are you sure you want to take this action? It cannot be undone. The
                                    user will be removed from the system and will not be able to log in.
                                </div>
                                <div class="form-row mt-3">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="terminationDate">Termination Date</label>
                                        <input id="terminationDate" type="date" name="termination_date" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="submit" class="btn btn-danger">
                                    Yes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endcan
</div>

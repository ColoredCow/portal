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
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>  
        </div>
      </div>
    </div>
</div>

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
            <div class="form-group">
                <label class="font-weight-bold" for="">Designation:</label>
                <span>{{ $user->employee->designation }}</span>
                @foreach ($designations as $designation )
                    <span>{{ $user->employee->designation_id == $designation['id'] ? $designation['designation'] : "" }}</span>
                    @php
                        if($user->employee->designation_id == $designation['id']) $domainIndex = $designation['domain_id'];
                    @endphp
                @endforeach
            </div>
            <div class="form-group">
                <label class="font-weight-bold" for="">Domain:</label>
                @foreach ($domains as $domain )
                    <span>{{ $domainIndex == $domain['id'] ? $domain['domain'] : "" }}</span>
                @endforeach
            </div>
            <div class="form-group">
                <label class="font-weight-bold" for="">Email:</label>
                <span>{{ $user->email }}</span>
            </div>
            @includeWhen($user->profile, 'user::profile.subviews.show-user-profile-info')
        </div>
    </div>
    <div>
        <button class="btn btn-info" data-toggle="modal" id="editProfileBtn" data-target="#edit">Edit</button>
    </div>
</div>

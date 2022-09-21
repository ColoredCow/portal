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
                    <input type="text" class="form-control" id="designation" name="designation" required value="{{ $user->employee && $user->employee->designation ? $user->employee->designation : "" }}">
                </div>
                <div class="form-group">
                    <label>Domain</label>
                    <select class="form-control" name="domainId">
                        <option value="" disabled>Select Domain</option>

                        @foreach ($domains as $domain )
                        <option {{$domain['id'] == $user->employee->domain_id ? "selected" : ""}} value="{{ $domain['id'] }}">{{$domain['domain']}}</option>
                        @endforeach
                    </select>    
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" value="{{$user->email}}" readonly>
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <input type="text" class="form-control" id="gender" name="gender" required value="{{ $user->profile && $user->profile->gender ? $user->profile->gender : "" }}">
                </div>
                <div class="form-group">
                    <label for="date_of_birth">Date of birth</label>
                    <input type="text" class="form-control" id="date_of_birth" name="date_of_birth" required value="{{ $user->profile && $user->profile->date_of_birth ? $user->profile->date_of_birth : "" }}">
                </div>
                <div class="form-group">
                    <label for="spouse_name">Spouse</label>
                    <input type="text" class="form-control" id="spouse_name" name="spouse_name" required value="{{ $user->profile && $user->profile->spouse_name ? $user->profile->spouse_name : "" }}">
                </div>
                <div class="form-group">
                    <label for="date_of_joining">Date of joining</label>
                    <input type="text" class="form-control" id="date_of_joining" name="date_of_joining" required value="{{ $user->profile && $user->profile->date_of_joining ? $user->profile->date_of_joining : "" }}">
                <div class="form-group">
                    <label for="gender">Mobile</label>
                    <input type="text" class="form-control" id="mobile" name="mobile" required value="{{ $user->profile && $user->profile->mobile ? $user->profile->mobile : "" }}">
                </div>
                <div class="form-group">
                    <label for="father_name">Father</label>
                    <input type="text" class="form-control" id="father_name" name="father_name" required value="{{ $user->profile && $user->profile->father_name ? $user->profile->father_name : "" }}">
                </div>
                
                </div>
                <div class="form-group">
                    <label for="marital_status">Marital Status</label>
                    <input type="text" class="form-control" id="marital_status" name="marital_status" required value="{{ $user->profile && $user->profile->marital_status ? $user->profile->marital_status : "" }}">
                </div>
                <div class="form-group">
                    <label for="current_location">Current Location</label>
                    <input type="text" class="form-control" id="current_location" name="current_location" required value="{{ $user->profile && $user->profile->current_location ? $user->profile->current_location : "" }}">
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
            </div>
            <div class="form-group">
                <label class="font-weight-bold" for="">Domain:</label>
                @foreach ($domains as $domain )
                    <span>{{ $user->employee->domain_id == $domain['id'] ? $domain['domain'] : "" }}</span>
                @endforeach
            </div>
            <div class="form-group">
                <label class="font-weight-bold" for="">Email:</label>
                <span>{{ $user->email }}</span>
            </div>
            <div class="form-group">
                <label class="font-weight-bold" for="">Gender:</label>
                <span>{{ $user->profile->gender }}</span>
            </div>
            <div class="form-group">
                <label class="font-weight-bold" for="">Date of birth:</label>
                <span>{{ $user->profile->date_of_birth }}</span>
            </div>
            <div class="form-group">
                <label class="font-weight-bold" for="">Spouse:</label>
                <span>{{ $user->profile->spouse_name }}</span>
            </div>
            <div class="form-group">
                <label class="font-weight-bold" for="">Date of joining:</label>
                <span>{{ $user->profile->date_of_joining }}</span>
            </div>

            @includeWhen($user->profile, 'user::profile.subviews.show-user-profile-info')
        </div>
    </div>
    <div>
        <button class="btn btn-info" data-toggle="modal" id="editProfileBtn" data-target="#edit">Edit</button>
    </div>
</div>


  <!-- Modal -->
<div class="modal fade" id="edit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel"><strong>Edit Profile</strong></h5>
          <button type="button" class="close" data-dismiss="modal"><b>&times;</b></button>
        </div>

        <div class="modal-body">
            <form action="{{route('profile.update', ['userId' => $user->id])}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required="required" value="{{$user->name}}">
                </div>
                <div class="form-group">
                    <label for="nickName">Nickname</label>
                    <input type="text" class="form-control" id="nickName" name="nickName" required="required" value="{{$user->nickname}}">
                </div>
                <div class="form-group">
                    <label for="designation">Designation</label>
                    <input type="text" class="form-control" id="designation" name="designation" required="required" value="{{ $user->employee && $user->employee->designation ? $user->employee->designation : "" }}">
                </div>
                <div class="form-group">
                    <label>Domain</label>
                    <select class="form-control" name="domainId">
                        <option value="" disabled>Select Domain</option>

                        @foreach ($domains as $domain )
                        <option {{$domain['domain'] == $user->employee->domain->domain ? "selected" : ""}} value="{{ $domain['id'] }}">{{$domain['domain']}}</option>
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

<?php
$connection = mysqli_connect("localhost","root","");
$db = mysqli_select_db($connection,'new_uat');

if(isset($_POST['UPDATE']))
$query = "UPDATE 'users' SET name='$_POST[name]'"
?>

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
        <button class="btn btn-info" data-toggle="modal" data-target="#edit">Edit</button>
    </div>
</div>


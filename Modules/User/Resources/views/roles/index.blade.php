 @extends('user::layouts.master')
 @section('content')
     <div class="container position-relative" id="vueContainer">
         @includeWhen(session('success'), 'toast', ['message' => session('success')])
         @include('user::layouts.navbar')
         <div class="">
             <button type="button" class="btn btn-success position-absolute top-0 right-0" data-toggle="modal"
                 data-target="#createRoleModal">
                 {{ __('Add New Roles') }}
             </button>
             <h4>Roles management</h4>
         </div>
         <div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="rolesModalLabel" aria-hidden="true">
             <div class="modal-dialog">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalLabel">Add Roles</h5>
                     </div>
                     <div class="modal-body">
                         <form method="POST" action="{{ route('roles.add-roles') }}" id="create-form">
                             @csrf
                             <div class="mb-3">
                                 <label for="name" class="form-label">Name<strong class="text-danger"></strong></label>
                                 <input type="text" class="form-control" name="name" required>
                             </div> 
                             <div class="mb-3">
                                 <label for="name" class="form-label">Guard Name<strong
                                         class="text-danger"></strong></label>
                                 <input type="text" class="form-control" name="guard_name" value="web" readonly>
                             </div>
                             <div class="mb-3">
                                 <label for="description" class="form-label">Description</label>
                                 <input type="text" class="form-control" name="description">
                             </div>
                         </form>
                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                         <button type="button" class="btn btn-primary" form="create-form" id="save-btn-action">Add</button>
                     </div>
                 </div>
             </div>
         </div>
         <role-listing :roles="{{ json_encode($roles) }}" :permissions="{{ json_encode($permissions) }}"
             :update-route="{{ json_encode(route('permissions.module.index', ['module' => 'roles'])) }}" />
     </div>
     </div>
 @endsection

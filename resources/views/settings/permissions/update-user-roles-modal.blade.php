<div class="modal" tabindex="-1" role="dialog" id="update_user_roles_modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
                <h5 class="modal-title">Roles assigned to: <strong>@{{ users[currentUserIndex].name }}</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
			</div>
			<div class="modal-body">
			     <li v-for="role in roles" class="list-group-item">
	                <div :class=" (role.name != 'super-admin') ? 'form-check ml-3' : 'form-check'">
	                    <label class="form-check-label" >
	                    <input type="checkbox" :data-role="role.name" :value="role.id" class="form-check-input"> @{{ role.label }}
						</label>
						<p class="text-muted" style="font-size:12px;">@{{ role.description }}</p>
	                </div>
	            </li>
            </div>
			<div class="modal-footer">
				<button id="close_update_user_roles_modal" type="type" class="btn btn-light" data-dismiss="modal" aria-label="Close">Cancel</button>
                <button @click="updateRoles" type="button" type="button" class="btn btn-primary">Save</button>
			</div>
		</div>
	</div>
</div>

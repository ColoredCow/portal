<div class="modal" tabindex="-1" role="dialog" id="update_role_permissions_modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Permissions granted to: <b>@{{ roles[currentRoleIndex].name }}</b></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<ul class="list-group" >
					<li v-for="(permission, index) in permissions" class="list-group-item">
						<div class="form-check">
							<label class="form-check-label">
								<input type="checkbox" :data-permission="permission.name"  class=" book_category_input" :value="permission.id"> @{{ permission.name }}
							</label>
						</div>
					</li>
				</ul>
			</div>
			<div class="modal-footer">
				<button id="close_update_permission_modal" type="type" class="btn btn-light" data-dismiss="modal" aria-label="Close">Cancel</button>
				<button @click="updatePermissions" type="button" type="button" class="btn btn-primary">Save</button>
			</div>
		</div>
	</div>
</div>

<template>
    <div class="modal" tabindex="-1" role="dialog" id="update_role_permissions_modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Permissions granted to: <b>{{ this.role.label }}</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <li v-for="(permission, index) in permissions" class="list-group-item" :key="index">
                            <div class="form-check">
                                <label class="form-check-label c-pointer">
                                    <input
                                        type="checkbox"
                                        class="book_category_input c-pointer"
                                        :data-permission="permission.name"
                                        :value="permission.id"
									/>
									{{ permission.name }}
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button id="close_update_permission_modal" type="type" class="btn btn-light" data-dismiss="modal" aria-label="Close">Cancel</button>
                    <button @click="updatePermissions" type="button"  class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
export default {

	props:["role", "permissions", "updateRoute"],

	data(){
		return {
			permissionInputs:[]
		};
	},

	methods: {

		setupUserPermissions: function() {
			let permissions = this.role.permissions;
			if(!permissions) {
				return false;
			}

			let permissionInputContainer = document.querySelector("#update_role_permissions_modal");
			let allPermissionInputs = permissionInputContainer.querySelectorAll("input[type='checkbox']");
			allPermissionInputs.forEach((checkbox) => {this.permissionInputs[checkbox.value] = checkbox; console.log("checkbox.value");});
			this.permissionInputs.map((checkbox) => checkbox.checked = false);
			permissions.forEach((permission) => this.permissionInputs[permission.id].checked =  true );
		},

		updatePermissions() {
			let selectedPermissions = [];
			let roleID = this.role.id;

			this.permissionInputs.forEach(function(checkbox) {
				if(checkbox.checked) {
					selectedPermissions.push({
						name:checkbox.dataset.permission,
						id:checkbox.value
					});
				}
			});
			let route = `${this.updateRoute}/${roleID}`;
			axios.put(route, {
				permissions: JSON.parse(JSON.stringify(selectedPermissions)),
				roleID: roleID
			});

			document.getElementById("update_role_permissions_modal").click();
			this.$emit("rolePermissionsUpdated", selectedPermissions);
		}
	},

	watch: {
		role: function(selectedRole) {
			this.setupUserPermissions();
		}
	},

};
</script>

<template>
    <div class="modal" tabindex="-1" role="dialog" id="update_user_roles_modal">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Roles assigned to: <strong> {{ this.user.name }}  </strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div>
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a id="portal" class="nav-link active c-pointer" @click="setActiveTile('portal')">Portal</a>
                            </li>
                            <li class="nav-item">
                                <a id="website" class="nav-link c-pointer"  @click="setActiveTile('website')">Website</a>
                            </li>
                        </ul>
                    </div>

                    <div v-show="this.activeTile == 'portal'" class="modal-body">
                        <li v-for="(role, index) in this.roles" class="list-group-item" :key="index">
                            <div class="form-check">
                                <label class="form-check-label" style="cursor: pointer;">
                                    <input
                                        type="checkbox"
                                        style="cursor: pointer;"
                                        :data-role="role.name"
                                        :data-label="role.label"
                                        :value="role.id"
                                        @click="checkForSuperAdmin(role)"
                                    />
									{{ role.label }}
                                </label>
                                <div class="text-muted fz-12 ml-3">{{ role.description }}</div>
                            </div>
                        </li>
                    </div>

                    <div v-show="this.activeTile == 'website'" class="modal-body">
                        <li>
                                <label v-if="this.user.websiteUserRole" class="form-check-label">{{ this.user.websiteUserRole }}</label>
                                <label v-else class="form-check-label" style="cursor: pointer;">No Access provided</label>
                                <p class="text-muted" style="font-size:12px;">You can set these roles from the website dashboard.
                                   <a v-if="this.user.websiteUser" :href="(this.user.websiteUser) ? this.getWebsiteUserProfileUrl() :'' ">Please click here to manage that. </a>
                                </p>
                        </li>

                    </div>

                    <div class="modal-footer">
                        <button id="close_update_user_roles_modal" type="type" class="btn btn-light" data-dismiss="modal" aria-label="Close">Cancel</button>
                        <button @click="updateUserRoles" type="button"  class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
export default {

	props:["user", "updateRoute", "config"],

	data(){
		return {
			roles: [],
			roleInputs:[],
			activeTile:"portal"

		};
	},

	methods: {
		async getRoles() {
			let response = await axios.get("user/get-roles");
			this.roles = response.data;
		},

		setupUserRoles: function() {
			let userRoles = this.user.roles;
			if(!userRoles) {
				return false;
			}


			let roleInputContainer = document.querySelector("#update_user_roles_modal");
			let allRoleInputs = roleInputContainer.querySelectorAll("input[type='checkbox']");
			allRoleInputs.forEach((checkbox) => this.roleInputs[checkbox.value] = checkbox);

			if(userRoles.some(role => role.name == "super-admin")) {
				this.roleInputs.map((checkbox) => checkbox.checked = true);
				return;
			}

			this.roleInputs.map((checkbox) => checkbox.checked = false);
			userRoles.forEach((role) => this.roleInputs[role.id].checked =  true);
		},

		updateUserRoles() {
			let selectedRoles = [];
			let userID =  this.user.id;
			this.roleInputs.forEach(function(checkbox) {
				if(checkbox.checked) {
					selectedRoles.push({
						name:checkbox.dataset.role,
						id:checkbox.value,
						label:checkbox.dataset.label
					});
				}
			});

			let route = `${this.updateRoute}`;
			axios.put(route, { roles: JSON.parse(JSON.stringify(selectedRoles)), user_id: userID});
			document.getElementById("close_update_user_roles_modal").click();

			this.$emit("userRolesUpdated", selectedRoles);
		},

		checkForSuperAdmin(role) {
			if(role.name != "super-admin") {
				if(!this.roleInputs[role.id].checked) {
					this.roleInputs.map((checkbox) => (checkbox.dataset.role == "super-admin") ? checkbox.checked = false : "");
				}
				return true;
			}


			if(this.roleInputs[role.id].checked) {
				this.roleInputs.map((checkbox) => checkbox.checked = true);
				return true;
			}

			this.roleInputs.map((checkbox) => checkbox.checked = false);
			return true;
		},

		setActiveTile(tile) {
			this.activeTile = tile;
			document.querySelector(".active").classList.remove("active");
			document.querySelector(`#${tile}`).classList.add("active");

		},

		getWebsiteUserProfileUrl() {
			return this.config.website_url
                        + "/wp/wp-admin/user-edit.php"
                        + "?idp_referrer=" + window.location.href
                        + "&user_id=" + this.user.websiteUser.ID;


		}

	},

	watch: {
		user: function(selectedUser) {
			this.setupUserRoles();
		}
	},

	mounted: function() {
		this.getRoles();
	}

};
</script>

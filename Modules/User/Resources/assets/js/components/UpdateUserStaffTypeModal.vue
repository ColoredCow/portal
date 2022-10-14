<template>
    <div class="modal" tabindex="-1" role="dialog" id="update_staff_type_modal">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Set user's type in working staff: <strong> {{ this.user.name }}  </strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <label class="w-75 form-control-label" for="Staff Type">Working Staff Type</label>
                    <select class="w-75 form-control" name="" id="" @change="onChange($event)" >
                        <option value="">Select Working Staff Type</option>
                        <option value="Employee">Employee</option>
                        <option value="Intern">Intern</option>
                        <option value="Contractor">Contractor</option>
                        <option value="Support Staff">Support Staff</option>
                    </select>
                    </div>

                    <!-- <div v-show="this.activeTile == 'portal'" class="modal-body">
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
                    </div> -->
                    <div class="modal-footer">
                        <button id="close_update_user_roles_modal" type="type" class="btn btn-light" data-dismiss="modal" aria-label="Close">Cancel</button>
                        <button @click="updateStaffType" type="button"  class="btn btn-primary">Save</button>
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
			activeTile:"portal",
            StaffType:"",
            typeOfStaff:"",
            
            
		};
        
	},

	methods: {
		async getRoles() {
			let response = await axios.get("user/get-roles");
			this.roles = response.data;
		},
        onChange(e){
            this.StaffType=(e.target.value);
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

		updateStaffType() {

			axios.post("/user/add-staff-type", {typeOfStaff: this.StaffType, id: this.user.id})
				.then((response) => {
                    console.log("success");
					window.location.reload(); //since we are not using vue-router
					this.destroyFormModal();
				})
				.catch(error => {
					console.log("err", error);
				});

            console.log(this.StaffType);
			let selectedRoles = [];
			let userID =  this.user.id;
			this.roleInputs.forEach(function(checkbox) {
				if(checkbox.checked) {
					selectedRoles.push({
						name: checkbox.dataset.role,
						id: checkbox.value,
						label: checkbox.dataset.label
					});
				}

			});

			let route = `${this.updateRoute}`;
			axios.put(route, { roles: JSON.parse(JSON.stringify(selectedRoles)), user_id: userID});
			document.getElementById("close_update_user_roles_modal").click();

			this.$emit("userRolesUpdated", selectedRoles);
			this.$toast.success(" User staff type updated successfully!");
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

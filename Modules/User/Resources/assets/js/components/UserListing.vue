<template>
    <div>
		<div class="my-2">
			<input type="text" class="form-control" v-model="search" placeholder="Search User Name">
		</div>
        <table class="table table-bordered table-striped">
			<thead class="thead-dark">
				<tr>
					<th width="20%">User Name</th>
					<th width="35%">User Roles</th>
					<th>Actions</th>
				</tr>
			</thead>
            <tbody>
                <tr v-for="(user,index) in filteredUsers" :key="index">
                    <td>
                        <span class="align-items-center d-flex justify-content-start">
                            <div style="width:30px;" class="mr-2">
                                <img style="border-radius:50%"  class="w-full" :src="user.avatar" alt="">
                            </div>
                            {{ user.name }}
                        </span>
                        </td>
                    <td> 
                        <span>{{ formatRoles(user) }}<span v-if="user.websiteUserRole">, {{user.websiteUserRole}}</span></span>
                    </td>

                    <td>
                        <div class="dropdown d-none">
                            <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Select action
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                
                                <a v-show="userPermissions['can-assign-roles']" class="dropdown-item" data-toggle="modal" data-target="#update_user_roles_modal" @click="updateUserRolesModal(index)" href="#">Assign roles</a>
                                <a v-show="userPermissions['can-delete']" class="dropdown-item text-danger"  @click="removeUser(index)"  ref="#">Remove this user</a>
                            </div>
                        </div>

                        <div >
                            <button v-show="userPermissions['can-assign-roles']" class="btn btn-sm btn-outline-info mr-4" data-toggle="modal" data-target="#update_user_roles_modal" @click="updateUserRolesModal(index)">Manage user roles</button>
                            <button v-show="userPermissions['can-delete']" type="button" class="btn btn-sm btn-outline-danger " data-toggle="modal" data-target="#exampleModal" @click="setIndex(index)">Remove user</button>
                        </div>

                    </td>
                </tr>
            </tbody>
		</table>

		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-body">
						Are you sure?
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						<button type="button"  @click="removeUser(index)" class="btn btn-danger">Yes</button>
					</div>
				</div>
			</div>
		</div>
         
        <user-role-update-modal 
            :user="this.selectedUser"
            :updateRoute="this.updateRoute"
            :config="config"
            @userRolesUpdated="this.onUserRoleUpdated"

        />
    </div>
</template>

<script>
export default {
	props:[ "users", "updateRoute", "userPermissions", "config"],

	data(){
		return { 
			currentUserIndex: 0,
			roleInputs: [],
			allUsers: this.users,
			selectedUser:{},
			search: ""
		};  
	},

	methods: {
		formatRoles(user) {
			let roleNames = [];
			let userRoles = user.roles;
			for(var i in userRoles) {
				let role = userRoles[i];
				if(role.name == "super-admin") {
					return role.label;
				}
				let roleName = userRoles[i].label;
				roleNames.push(roleName);
			}
        
			return (roleNames.length) ? roleNames.join(", ") : "-";
		},

		updateUserRolesModal: function(index) {
			this.currentUserIndex = index;
			this.selectedUser = this.users[index];
		},

		onUserRoleUpdated: function(selectedRoles) {
			Vue.set(this.selectedUser, "roles",  selectedRoles);
		},

		removeUser: async function() {
			let user = this.users[this.currentUserIndex];
			let route = `/user/${user.id}/delete`;
			let response = await axios.delete(route);
			window.location.reload();
			this.$delete(this.allUsers, index);
		},
		
		setIndex: function(index){
			this.currentUserIndex = index;

		}
	},

	computed: {
		filteredUsers: function() {
			return this.allUsers.filter((user) => {
				return user.name.match(this.search.charAt(0).toUpperCase() + this.search.slice(1));
			});
		}
	}
};
</script>
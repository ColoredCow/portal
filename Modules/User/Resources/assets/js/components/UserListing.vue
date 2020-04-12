<template>
    <div>
        <table class="table table-bordered table-striped">
			<thead class="thead-dark">
				<tr>
					<th width="20%">User Name</th>
					<th width="35%">User Roles</th>
					<th>Actions</th>

				</tr>
			</thead>
            <tbody>
			<tr v-for="(user,index) in this.allUsers" :key="index">
				<td>
                    <span class="align-items-center d-flex justify-content-start">
                        <div style="width:50px;" class="mr-2">
                            <img style="border-radius:50%"  class="w-100" :src="user.avatar" alt="">
                        </div>
               
                        {{ user.name }}

                    </span>
                    </td>
				<td> {{ formatRoles(user) }} </td>
				<td>
					<button class="btn btn-sm btn-outline-danger" v-if="user.roles.length == 0" data-toggle="modal" data-target="#update_user_roles_modal" @click="updateUserRolesModal(index)">No role assigned</button>
					<button class="btn btn-sm btn-outline-info" v-else data-toggle="modal" data-target="#update_user_roles_modal" @click="updateUserRolesModal(index)">View roles assigned</button>
					<button class="btn btn-sm btn-outline-danger " data-target="#update_user_roles_modal" @click="updateUserRolesModal(index)">Remove User</button>
				</td>
			</tr>
            </tbody>
		</table>


        <user-role-update-modal 
            :user="this.selectedUser"
            :updateRoute="this.updateRoute"
            @userRolesUpdated="this.onUserRoleUpdated"
        />
    </div>
</template>

<script>
    export default {
        props:[ 'users', 'updateRoute'],

        data(){
            return { 
                currentUserIndex: 0,
                roleInputs: [],
                allUsers: this.users,
                selectedUser:{}
            }  
        },

        methods: {
            formatRoles(user) {
                let roleNames = [];
                let userRoles = user.roles;
                for(var i in userRoles) {
                    let roleName = userRoles[i].label;
                    roleNames.push(roleName);
                }
        
                return roleNames.join(', ');
            },

            updateUserRolesModal: function(index) {
                this.currentUserIndex = index;
                this.selectedUser = this.users[index];
            },

            onUserRoleUpdated: function(selectedRoles) {
                Vue.set(this.selectedUser, 'roles',  selectedRoles);
            }
        }
    }
</script>
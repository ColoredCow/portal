<template>
    <div>
        <div class="modal" tabindex="-1" role="dialog" id="update_user_roles_modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Roles assigned to: <strong> {{ users[this.currentUserIndex].name }}  </strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <li v-for="(role, index) in roles" class="list-group-item" :key="index">
                            <div :class=" (role.name != 'super-admin') ? 'form-check ml-3' : 'form-check'">
                                <label class="form-check-label" >
                                    <input type="checkbox" 
                                        :data-role="role.name" 
                                        :data-label="role.label"
                                        :value="role.id" 
                                        class="form-check-input"> {{ role.label }}
                                </label>
                                <p class="text-muted" style="font-size:12px;">{{ role.description }}</p>
                            </div>
                        </li>
                    </div>
                    <div class="modal-footer">
                        <button id="close_update_user_roles_modal" type="type" class="btn btn-light" data-dismiss="modal" aria-label="Close">Cancel</button>
                        <button @click="updateRoles" type="button"  class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props:[ 'users', 'roles', 'updateRoute'],

        data(){
            return { 
                currentUserIndex: 0,
                roleInputs: [],
                allUsers: this.users
            }  
        },

        mounted() {
    
        },

        methods: {
            formatRoles(user) {
                let roleNames = [];
                let userRoles = JSON.parse(JSON.stringify(user.roles))
                //console.log('user.roles', userRoles);
                for(var i in userRoles) {
                    let roleName = userRoles[i].label;
                    roleNames.push(roleName);
                }

                console.log(user.name, userRoles, roleNames);
        
                return roleNames.join(', ');
            },

            updateUserRolesModal: function(index) {
                let roles = this.users[index]['roles'];
                if(!roles) {
                    return false;
                }

                this.currentUserIndex = index;
                this.roleInputs.map((checkbox) => checkbox.checked = false);
                roles.forEach((role) => this.roleInputs[role.id].checked =  true);
            },

            updateRoles: function() {
                let selectedRoles = [];
                let userID =  0;
                if(this.allUsers) {
                    userID = this.allUsers[this.currentUserIndex].id;
                }
 
                this.roleInputs.forEach(function(checkbox) {
                    if(checkbox.checked) {
                        selectedRoles.push({
                            name:checkbox.dataset.role,
                            id:checkbox.value,
                            label:checkbox.dataset.label
                        });
                    }
                });

                Vue.set(this.allUsers[this.currentUserIndex], 'roles',  selectedRoles);
                let route = `${this.updateRoute}/${userID}`;
                axios.put(route, {
                    roles: JSON.parse(JSON.stringify(selectedRoles)),
                    userID: userID
                });
                document.getElementById('close_update_user_roles_modal').click();
            },
        },

        mounted: function() {
            let roleInputContainer = document.querySelector("#update_user_roles_modal");
            let allRoleInputs = roleInputContainer.querySelectorAll('input[type="checkbox"]');
            allRoleInputs.forEach((checkbox) => this.roleInputs[checkbox.value] = checkbox);
        }
    }
</script>
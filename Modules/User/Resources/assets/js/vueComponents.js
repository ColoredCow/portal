import Vue from "vue";
import UserListing from "./components/UserListing.vue";
import RoleListing from "./components/RoleListing.vue";
import UpdateUserRoleModal from "./components/UpdateUserRoleModal.vue";
import UpdateUserStaffTypeModal from "./components/UpdateUserStaffTypeModal.vue";
import UpdateRolePermissionModal from "./components/UpdateRolePermissionModal.vue";

Vue.component("user-listing", UserListing);
Vue.component("role-listing", RoleListing);
Vue.component("user-role-update-modal", UpdateUserRoleModal);
Vue.component("user-staff-type-update-modal", UpdateUserStaffTypeModal);
Vue.component("role-permission-update-modal", UpdateRolePermissionModal);

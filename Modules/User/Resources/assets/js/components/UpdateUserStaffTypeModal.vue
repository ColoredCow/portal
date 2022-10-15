	<template>
	<div class="modal" tabindex="-1" role="dialog" id="update_staff_type_modal">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Set user's type in working staff: <strong> {{ this.user.name }} </strong>
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<label class="w-75 form-control-label" for="Staff Type">Working Staff Type</label>
					<select class="w-75 form-control" name="" id="" @change="onChange($event)">
						<option value="">Select Working Staff Type</option>
						<option value="Employee">{{stafftypes.employee}}</option>
						<option value="Intern">{{stafftypes.intern}}</option>
						<option value="Contractor">{{stafftypes.contractor}}</option>
						<option value="Support Staff">{{stafftypes.supportstaff}}</option>
					</select>
				</div>
				<div class="modal-footer">
					<button id="close_update_user_roles_modal" type="type" class="btn btn-light" data-dismiss="modal"
						aria-label="Close">Cancel</button>
					<button @click="updateStaffType" type="button" class="btn btn-primary">Save</button>
				</div>
			</div>
		</div>
	</div>
	</template>

<script>
export default {

	props: ["user", "config", "stafftypes"],
	data() {
		return {
			StaffType: "",
			typeOfStaff: "",
		};
	},

	methods: {
		onChange(e) {
			this.StaffType = (e.target.value);
		},

		updateStaffType() {

			axios.post("/user/add-staff-type", { typeOfStaff: this.StaffType, id: this.user.id })
				.then((response) => {
					window.location.reload(); //since we are not using vue-router
					this.destroyFormModal();
				})
				.catch(error => {
					console.log("err", error);
				});
		},

	}
};
</script>

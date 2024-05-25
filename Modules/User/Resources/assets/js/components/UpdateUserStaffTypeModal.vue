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
						<select class="w-75 form-control" name="" id="" @change="onChange($event, 'staffType')">
							<option value="" :selected="!this.user.employee.staff_type">Select Working Staff Type</option>
							<option value="Employee" :selected="this.user.employee.staff_type === 'Employee'">{{stafftypes.employee}}</option>
							<option value="Intern" :selected="this.user.employee.staff_type === 'Intern'">{{stafftypes.intern}}</option>
							<option value="Contractor" :selected="this.user.employee.staff_type === 'Contractor'">{{stafftypes.contractor}}</option>
							<option value="Support Staff" :selected="this.user.employee.staff_type === 'Support Staff'">{{stafftypes.supportstaff}}</option>
						</select>
						<label class="w-75 form-control-label mt-3" for="Staff Type">Payroll Type</label>
						<select class="w-75 form-control" name="" id="" @change="onChange($event, 'payrollType')" required>
							<option value="" :selected="!this.user.employee.payroll_type">Select Payroll Type</option>
							<option value="full-time" :selected="this.user.employee.payroll_type === 'full-time'">Full Time</option>
							<option value="contractor" :selected="this.user.employee.payroll_type === 'contractor'">Contractor</option>
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
			staffType: null,
			payrollType: null
		};
	},

	methods: {
		onChange(e, type) {
			const value = e.target.value
			if (type === "staffType") {
				this.staffType = value;
			} else {
				this.payrollType = value
			}
		},

		updateStaffType() {
			const newStaffType = this.staffType || this.user.employee.staff_type
			const newPayrollType = this.payrollType || this.user.employee.payroll_type

			console.log(newStaffType, newPayrollType)

			axios.post("/user/add-staff-type", { 
					typeOfStaff: newStaffType,  
					id: this.user.id,
					payrollType: newPayrollType
				})
				.then((response) => {
					window.location.reload(); //since we are not using vue-router
				})
				.catch(error => {
					console.log("err", error);
				});
		},

	}
};
</script>

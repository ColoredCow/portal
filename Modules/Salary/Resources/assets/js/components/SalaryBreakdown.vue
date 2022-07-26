<template>
	<div>
		<div class="row mb-3">
			<div class="col-md-4">
				<div class="text-secondary mb-1">Basic Salary</div>
				<div class="fz-30">
					<i class="fa fa-rupee"></i>
					<span>{{ basicSalary }}</span>
				</div>
			</div>
			<div class="col-md-4">
				<div class="text-secondary mb-1">HRA</div>
				<div class="fz-30">
					<i class="fa fa-rupee"></i>
					<span>{{ hra }}</span>
				</div>
			</div>
			<div class="col-md-4">
				<div class="text-secondary mb-1">Transport Allowance</div>
				<div class="fz-30">
					<i class="fa fa-rupee"></i>
					<span>{{ transportAllowance }}</span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="text-secondary mb-1">Food Allowance</div>
				<div class="fz-30">
					<i class="fa fa-rupee"></i>
					<span>{{ foodAllowance }}</span>
				</div>
			</div>
			<div class="col-md-4">
				<div class="text-secondary mb-1">Other Allowance</div>
				<div class="fz-30">
					<i class="fa fa-rupee"></i>
					<span>{{ otherAllowance }}</span>
				</div>
			</div>
			<div class="col-md-4">
				<div class="text-secondary mb-1">Total Salary</div>
				<div class="fz-30">
					<i class="fa fa-rupee"></i>
					<span>{{ totalSalary }}</span>
				</div>
			</div>
		</div>
    </div>
</template>

<script>
export default {
	props:["salaryConfigs", "grossSalary"],

	computed: {
		basicSalary() {
			let percentage = parseInt(this.salaryConfigs.basic_salary.percentage_rate);
			return Math.ceil(this.grossSalary * percentage / 100);
		},
		hra() {
			let percentage = parseInt(this.salaryConfigs.hra.percentage_rate);
			return Math.ceil(this.grossSalary * percentage / 100);
		},
		transportAllowance() {
			if (this.grossSalary === '') {
				return 0;
			}
			return parseInt(this.salaryConfigs.transport_allowance.fixed_amount);
		},
		foodAllowance() {
			if (this.grossSalary === '') {
				return 0;
			}
			return parseInt(this.salaryConfigs.food_allowance.fixed_amount);
		},
		otherAllowance() {
			return this.grossSalary - this.basicSalary - this.hra - this.transportAllowance - this.foodAllowance;
		},
		totalSalary() {
			return this.basicSalary + this.hra + this.transportAllowance + this.foodAllowance + this.otherAllowance;
		},
	},

    mounted() {
        console.log('this.salaryConfigs', this.salaryConfigs);
        console.log('this.grossSalary', this.grossSalary);
    }
};
</script>

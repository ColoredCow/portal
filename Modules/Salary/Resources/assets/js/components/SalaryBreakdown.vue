<template>
	<div>
        <h1>Breakdown</h1>
		<div class="input-group col-md-9 fz-24 ml-3">
			<span class="mr-2">Basic Salary:</span>
			<i class="fa fa-rupee"></i>
			<span>{{ basicSalary }}</span>
		</div>
		<div class="input-group col-md-9 fz-24 ml-3">
			<span class="mr-2">HRA:</span>
			<i class="fa fa-rupee"></i>
			<span>{{ hra }}</span>
		</div>
		<div class="input-group col-md-9 fz-24 ml-3">
			<span class="mr-2">Transport Allowance:</span>
			<i class="fa fa-rupee"></i>
			<span>{{ transportAllowance }}</span>
		</div>
		<div class="input-group col-md-9 fz-24 ml-3">
			<span class="mr-2">Food Allowance:</span>
			<i class="fa fa-rupee"></i>
			<span>{{ foodAllowance }}</span>
		</div>
		<div class="input-group col-md-9 fz-24 ml-3">
			<span class="mr-2">Other Allowance:</span>
			<i class="fa fa-rupee"></i>
			<span>{{ otherAllowance }}</span>
		</div>
		<div class="input-group col-md-9 fz-24 ml-3">
			<span class="mr-2">Total Salary:</span>
			<i class="fa fa-rupee"></i>
			<span>{{ totalSalary }}</span>
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

<template>
	<div>
		<div class="row mb-5">
			<div class="col-md-4">
				<div class="text-secondary mb-1">Basic Salary</div>
				<div class="fz-30">
					<i class="fa fa-rupee"></i>
					<span>{{ this.formatCurrency(basicSalary) }}</span>
				</div>
			</div>
			<div class="col-md-4">
				<div class="text-secondary mb-1">HRA</div>
				<div class="fz-30">
					<i class="fa fa-rupee"></i>
					<span>{{ this.formatCurrency(hra) }}</span>
				</div>
			</div>
			<div class="col-md-4">
				<div class="text-secondary mb-1">Transport Allowance</div>
				<div class="fz-30">
					<i class="fa fa-rupee"></i>
					<span>{{ this.formatCurrency(transportAllowance) }}</span>
				</div>
			</div>
		</div>
		<div class="row mb-5">
			<div class="col-md-4">
				<div class="text-secondary mb-1">Other Allowance</div>
				<div class="fz-30">
					<i class="fa fa-rupee"></i>
					<span>{{ this.formatCurrency(otherAllowance) }}</span>
				</div>
			</div>
			<div class="col-md-4">
				<div class="text-secondary mb-1">Food Allowance</div>
				<div class="fz-30">
					<i class="fa fa-rupee"></i>
					<span>{{ this.formatCurrency(foodAllowance) }}</span>
				</div>
			</div>
		</div>
		<div class="row mb-5">
			<div class="col-md-4">
				<div class="text-secondary mb-1">Total Salary</div>
				<div class="fz-30">
					<i class="fa fa-rupee"></i>
					<span>{{ this.formatCurrency(totalSalary) }}</span>
				</div>
			</div>
		</div>
		<h2 class="text-underline">Salary Deduction</h2>
		<br>
		<div class="row mb-5">
			<div class="col-md-4">
				<div class="text-secondary mb-1">Employee ESI</div>
				<div class="fz-30">
					<i class="fa fa-rupee"></i>
					<span>{{ this.formatCurrency(employeeEsi) }}</span>
				</div>
			</div>
			<div class="col-md-4">
				<div class="text-secondary mb-1">Employee EPF</div>
				<div class="fz-30">
					<i class="fa fa-rupee"></i>
					<span>{{ this.formatCurrency(employeeEpf) }}</span>
				</div>
			</div>
			<div class="col-md-4">
				<div class="text-secondary mb-1">TDS</div>
				<div class="fz-30">
					<span>N/A</span>
				</div>
			</div>
		</div>
		<div class="row mb-5">
			<div class="col-md-4">
				<div class="text-secondary mb-1">Food Deduction</div>
				<div class="fz-30">
					<i class="fa fa-rupee"></i>
					<span>{{ this.formatCurrency(foodAllowance) }}</span>
				</div>
			</div>
			<div class="col-md-4">
				<div class="text-secondary mb-1">Total Deduction</div>
				<div class="fz-30">
					<i class="fa fa-rupee"></i>
					<span>{{ this.formatCurrency(totalDeduction) }}</span>
				</div>
			</div>
		</div>
		<div class="row mb-5">
			<div class="col-md-4">
				<div class="text-secondary mb-1">Net Pay</div>
				<div class="fz-30">
					<i class="fa fa-rupee"></i>
					<span>{{ this.formatCurrency(netPay) }}</span>
				</div>
			</div>
		</div>
		<h2 class="text-underline">Employer Contribution</h2>
		<br>
		<div class="row mb-5">
			<div class="col-md-4">
				<div class="text-secondary mb-1">Employer ESI</div>
				<div class="fz-30">
					<i class="fa fa-rupee"></i>
					<span>{{ this.formatCurrency(employerEsi) }}</span>
				</div>
			</div>
			<div class="col-md-4">
				<div class="text-secondary mb-1">EPF Employer Share</div>
				<div class="fz-30">
					<i class="fa fa-rupee"></i>
					<span>{{ this.formatCurrency(employerEpf) }}</span>
				</div>
			</div>
			<div class="col-md-4">
				<div class="text-secondary mb-1">Administration Charges</div>
				<div class="fz-30">
					<i class="fa fa-rupee"></i>
					<span>{{ this.formatCurrency(administrationCharges) }}</span>
				</div>
			</div>
		</div>
		<div class="row mb-5">
			<div class="col-md-4">
				<div class="text-secondary mb-1">EDLI Charges</div>
				<div class="fz-30">
					<i class="fa fa-rupee"></i>
					<span>{{ this.formatCurrency(Math.ceil(edliCharges)) }}</span>
				</div>
			</div>
		</div>
		<div class="row mb-5">
			<div class="col-md-4">
				<div class="text-secondary mb-1">CTC</div>
				<div class="fz-30">
					<i class="fa fa-rupee"></i>
					<span>{{ this.formatCurrency(ctc) }}</span>
				</div>
			</div>
			<div class="col-md-4">
				<div class="text-secondary mb-1">CTC Annual</div>
				<div class="fz-30">
					<i class="fa fa-rupee"></i>
					<span>{{ this.formatCurrency(ctcAnnual) }}</span>
				</div>
			</div>
			<div class="col-md-4">
				<div class="text-secondary mb-1">Health Insurance</div>
				<div class="fz-30">
					<i class="fa fa-rupee"></i>
					<span>{{ this.formatCurrency(healthInsurance) }}</span>
				</div>
			</div>
		</div>
		<div class="row mb-5">
			<div class="col-md-4">
				<div class="text-secondary mb-1">CTC Aggregated</div>
				<div class="fz-30">
					<i class="fa fa-rupee"></i>
					<span>{{ this.formatCurrency(ctcAggregated) }}</span>
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
			let multiplier = this.grossSalary;
			if (this.salaryConfigs.hra.percentage_applied_on == "basic_salary") {
				multiplier = this.basicSalary;
			}
			let percentage = parseInt(this.salaryConfigs.hra.percentage_rate);
			return Math.ceil(multiplier * percentage / 100);
		},
		transportAllowance() {
			if (this.grossSalary === "") {
				return 0;
			}
			return parseInt(this.salaryConfigs.transport_allowance.fixed_amount);
		},
		foodAllowance() {
			if (this.grossSalary === "") {
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
		employeeEsi() {
			if(this.grossSalary < this.salaryConfigs.employee_esi_limit.fixed_amount) {
				let percentage = this.salaryConfigs.employee_esi.percentage_rate;
				return Math.ceil(this.grossSalary * percentage / 100);
			}
			return 0;
		},
		employeeEpf() {
			let multiplier = this.grossSalary;
			if (this.salaryConfigs.employee_epf.percentage_applied_on == "basic_salary") {
				multiplier = this.basicSalary;
			}
			let percentage = parseInt(this.salaryConfigs.employee_epf.percentage_rate);
			return Math.ceil(multiplier * percentage / 100);
		},
		totalDeduction() {
			return this.employeeEsi + this.employeeEpf + this.foodAllowance;
		},
		netPay() {
			return this.totalSalary - this.totalDeduction;		
		},
		employerEsi() {
			if(this.grossSalary < this.salaryConfigs.employer_esi_limit.fixed_amount) {
				let percentage = this.salaryConfigs.employer_esi.percentage_rate;
				return Math.ceil(this.grossSalary * percentage / 100);
			}
			return 0;
		},
		employerEpf() {
			let multiplier = this.grossSalary;
			if (this.salaryConfigs.employer_epf.percentage_applied_on == "basic_salary") {
				multiplier = this.basicSalary;
			}
			let percentage = parseInt(this.salaryConfigs.employer_epf.percentage_rate);
			return Math.ceil(multiplier * percentage / 100);
		},
		administrationCharges() {
			let multiplier = this.grossSalary;
			if (this.salaryConfigs.administration_charges.percentage_applied_on == "basic_salary") {
				multiplier = this.basicSalary;
			}
			let percentage = this.salaryConfigs.administration_charges.percentage_rate;
			return Math.ceil(multiplier * percentage / 100);
		},
		edliCharges() {
			let multiplier = this.grossSalary;
			if (this.salaryConfigs.edli_charges.percentage_applied_on == "basic_salary") {
				multiplier = this.basicSalary;
			}
			let percentage = this.salaryConfigs.edli_charges.percentage_rate;
			return Math.min(Math.ceil(multiplier * percentage / 100) , Math.ceil(this.salaryConfigs.edli_charges_limit.fixed_amount * percentage / 100));
		},
		ctc() {
			return Math.ceil(parseInt(this.grossSalary) + parseInt(this.employerEsi) + parseInt(this.employerEpf) + parseInt(this.administrationCharges) + parseInt(this.edliCharges));
		},
		ctcAnnual() {
			return this.ctc * 12;		
		},
		healthInsurance() {
			if (this.grossSalary === "" || this.employerEsi !== 0 || this.employeeEsi !== 0) {
				return 0;
			}
			return parseInt(this.salaryConfigs.health_insurance.fixed_amount);
		},
		ctcAggregated() {
			return this.ctcAnnual + this.healthInsurance;		
		},
	},
	methods: {
		formatCurrency(amount) {
			return amount.toLocaleString("en-IN");
		},
	}
};
</script>

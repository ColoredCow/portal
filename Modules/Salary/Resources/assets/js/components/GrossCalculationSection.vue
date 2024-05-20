<template>
	<div>
		<small class="pl-6"><strong> Due to financial calculation the applicable CTC will be {{ this.formatCurrency(ctcAggregated) }}</strong></small>
		<div class="row pl-2 mt-2">
			<input hidden type="number" step="0.01" v-model="grossSalary" name="grossSalary" class="form-control bg-light" placeholder="Monthly Gross Salary" min="0" required>
			<input hidden type="number" step="0.01" v-model="ctcAggregated" name="ctcAggregated" class="form-control bg-light" min="0" required>
			<div class="form-group pl-6 col-md-5">
				<div class="leading-none fz-24 mb-2">Monthly Gross Salary</div>
				<div class="fz-24">
					<i class="fa fa-rupee"></i>
					<span>{{ this.formatCurrency(grossSalary) }}</span>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props:["salaryConfigs", "grossCalculationData", "tds", "loanDeduction", "proposedCtc"],

	computed: {
		grossSalary() {
			if (!Number.isFinite(parseInt(this.proposedCtc)) || parseInt(this.proposedCtc) === 0) {
				return 0
			}
			let grossSalary = 
            (100 * parseFloat(this.proposedCtc) - (12 * parseFloat(this.grossCalculationData.edliChargesPercentageRate) * parseFloat(this.grossCalculationData.edliChargesLimit))) / 
            (12 * (100 + (parseFloat(this.grossCalculationData.epfPercentageRate) * parseFloat(this.grossCalculationData.basicSalaryPercentageFactor)) + (parseFloat(this.grossCalculationData.adminChargesPercentageRate) * parseFloat(this.grossCalculationData.basicSalaryPercentageFactor))));

			if((grossSalary * parseFloat(this.grossCalculationData.basicSalaryPercentageFactor)) < parseFloat(this.grossCalculationData.edliChargesLimit)) {
				grossSalary = 
					(100 * parseFloat(this.proposedCtc)) / (1200 + (12 * parseFloat(this.grossCalculationData.basicSalaryPercentageFactor) * (parseFloat(this.grossCalculationData.epfPercentageRate) + parseFloat(this.grossCalculationData.edliChargesPercentageRate) + parseFloat(this.grossCalculationData.adminChargesPercentageRate))));
			}
			
			grossSalary = Math.ceil(grossSalary - (parseFloat(this.grossCalculationData.insuranceAmount) / 12))

			return grossSalary + (100 - (grossSalary % 100))
		},
		monthlyLoanDeduction() {
			return this.loanDeduction
		},
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
			if(this.grossSalary <= parseInt(this.salaryConfigs.employee_esi_limit.fixed_amount)) {
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
			return this.employeeEsi + this.employeeEpf + this.foodAllowance + this.loanDeduction + this.tds;
		},
		netPay() {
			return this.totalSalary - this.totalDeduction;		
		},
		employerEsi() {
			if(this.grossSalary < parseInt(this.salaryConfigs.employer_esi_limit.fixed_amount)) {
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
			return Math.min(Math.ceil(multiplier * percentage / 100) , Math.ceil(parseInt(this.salaryConfigs.edli_charges_limit.fixed_amount) * percentage / 100));
		},
		ctc() {
			if (this.grossSalary === "") {
				return 0;
			}
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
			if (!Number.isFinite(this.grossSalary) || parseInt(this.grossSalary) === 0) {
				return 0
			}
			return this.ctcAnnual + this.healthInsurance;		
		},
	},
	methods: {
		formatCurrency(amount) {
			if (!Number.isFinite(amount)) {
				return ""
			}
			return amount.toLocaleString("en-IN");
		},
	}
};
</script>

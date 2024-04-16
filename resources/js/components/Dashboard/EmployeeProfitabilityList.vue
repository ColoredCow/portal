<template>
	<div class = "media">
		<div class="card">
			<div class="card-header p-1">
			<h3 class="text-center"><a href="/report/finance/employee/profitibality?staff_type=Employee&status=current">Employee Profitability List</a></h3>
			</div>
			<div class="md-0">
				<div class="card-body pt-3 h-325 w-md-389 w-389 overflow-y-scroll">
					<ul class="list list-group unstyled-list">
						<li class="d-flex justify-content-between">
						<div class="text-secondary"> Fetching latest data... </div>
						<h4 v-text="sentInvoiceCount"></h4>
						</li>
						<hr class="mt-1" />
					</ul>
				</div>
			</div>
		</div>
	</div>
</template>


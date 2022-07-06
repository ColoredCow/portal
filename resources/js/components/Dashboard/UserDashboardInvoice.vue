<template>
  <div class="card w-450">
    <div class="card-header p-1">
      <h3 class="text-center"><a href="/invoice">Invoices</a></h3>
    </div>
    <div class="card-body pt-3" style="height: 18em; overflow: auto;">
      <ul class="list list-group unstyled-list">
        <li style="font-size:16px;">
          <div class="text-secondary"> Pending invoices </div>
          <h4 v-text="sentInvoiceCount"></h4>
        </li>
        <hr class="mt-1 w-full" />
      </ul>
    </div>
  </div>
</template>

<script>
export default {
	props: [],
	data() {
		return {
			sentInvoiceCount: 0,
		};
	},

	methods: {
		async getDashboardData() {
			let response = await axios.get("/invoice/dashboard");
			let sentInvoices = response.data;
			this.sentInvoiceCount = sentInvoices.length;
		},
	},

	mounted() {
		this.getDashboardData();
	},
};
</script>

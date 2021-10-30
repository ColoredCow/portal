<template>
    <div class="card">
        <div class="card-header p-1">
            <h3 class="text-center"><a href="/infrastructure">Infrastructure</a></h3>
        </div>
         <div class="card-body pt-3" style="height: 18em;overflow: auto;">
            <ul v-if="this.billingDetails.current_amount" class="list list-group unstyled-list">
                <li style="font-size:16px;">
                    <span class="d-block"> Unbilled amount till today </span> 
                    <div :class="'cost badge p-2 ' + this.currentAmountClass "> {{ this.billingDetails.current_amount }} </div> 
                </li>
                <hr class="mt-1 w-full">

                <li style="font-size:16px;">
                    <span class="d-block"> Forcast for this month </span> 
                    <div class="cost badge badge-info p-2">{{ this.billingDetails.forcast_amount }}</div> 
                </li>
                <hr class="mt-1 w-full">

                <li style="font-size:16px;">
                    <span class="d-block"> Last Month amount </span> 
                    <div class="cost badge badge-info p-2">{{ this.billingDetails.last_month_amount }}</div> 
                </li>
                <hr class="mt-1 w-full">

                <li style="font-size:16px;">
                    <div class="d-block"><span> Average <span class="fz-12">(Based on last year data)</span> </span></div>
                    <div class="cost badge badge-warning p-2">{{ this.billingDetails.avg_by_last_year }}</div> 
                </li>
                <hr class="mt-1 w-full">

            </ul>

            <div v-else>
                <p>Fetching latest data...</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
	props: [],
	data() {
		return {
			billingDetails:{
				current_amount:"",
				last_month_amount:"",
				forcast_amount:"",
				should_alert:false,
				avg_by_last_year:""
			},

			currentAmountClass:"badge-info"
		};
	},

	methods: {
		async getBillingDetails() {
			let response = await axios.get("/infrastructure/billing-details");
			this.billingDetails =  response.data;
			if(this.billingDetails.should_alert) {
				this.currentAmountClass = "badge-danger";
			}

		}
	},

	mounted() {
		this.getBillingDetails();
	}
};
</script>
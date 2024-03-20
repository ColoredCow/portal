<template>
    <div class="px-2 pt-2">
        <div class="row text-left d-flex justify-content-between" >
            <div class="text-secondary"> Total received applications </div>
            <h4>{{ this.hiringData.total_received_applications }}</h4>
        </div>
        <hr class="mt-1">
        <div class="row text-left d-flex justify-content-between mt-2" >
            <div class="text-secondary"> Total rejected applications </div>
            <h4>{{ this.hiringData.total_rejected_applications }}</h4>
        </div>
        <hr class="mt-1">
        <div class="row text-left d-flex justify-content-between mt-2" >
            <div class="text-secondary"> Total introductory call applications </div>
            <h4>{{ this.hiringData.total_introductory_call_applications }}</h4>
        </div>
        <hr class="mt-1">
        <div class="row text-left d-flex justify-content-between mt-2" >
            <div class="text-secondary"> Total new applications </div>
            <h4>{{ this.hiringData.total_new_applications }}</h4>
        </div>
        <hr class="mt-1">
    </div>
</template>

<script>
export default {
	props: [],
	data() {
		return {
			hiringData:[]
		};
	},

	methods: {
		async getHiringData() {
			let response = await axios.post("/dashboart/hiring-activity", {"filter" : "last-month"});
			this.hiringData =  response.data;

		}
	},

	mounted() {
		this.getHiringData();
	}
};
</script>

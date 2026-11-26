import Vue from "vue";
import Payment from "../components/Finance/Payment.vue";

Vue.component("payment", Payment);

if (document.getElementById("form_payment")) {
	const projectContainer = new Vue({
		el: "#form_payment",
	});
}

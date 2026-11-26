import Vue from "vue";
import * as InvoiceComponent from "../components/Finance/Invoice.vue";

Vue.component("invoice", InvoiceComponent.invoice);

if (document.getElementById("form_invoice")) {
	const invoiceForm = new Vue({
		el: "#form_invoice",
	});
}

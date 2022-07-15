/*
   * Finance - Invoices module JS code
   */
$(document).ready(function(){
	$("#amount").on("keyup", function(){
		var currency = document.getElementById("currency").value;
		var value = document.getElementById("amount").value;
		switch (currency) {
		case "INR":
			value = value * 0.18 + 1 * value;
			var fraction = Math.round((value % 1) * 100);
			var fraction_text = "";
			if (fraction > 0) {
				fraction_text = "AND " + convert_number(fraction) + " PAISE";
			}
			var output = convert_number(value) + " RUPEE " + fraction_text + " ONLY";
			break;
		case "USD":
			var fraction = Math.round((value % 1) * 100);
			var fraction_text = "";
			if (fraction > 0) {
				fraction_text = "AND " + convert_number(fraction) + " CENTS";
			}
			var output = convert_number(value) + " DOLLAR " + fraction_text + " ONLY";
			break;
		}
		document.getElementById("container").innerHTML = output;
	});

	$(".show-preview").on("click", function() {
		var invoiceData = $(this).data("invoice-data");
		var mapping = {
			"|*project_name*|": invoiceData["projectName"],
			"|*term*|": invoiceData["monthName"],
			"|*year*|": invoiceData["year"],
			"|*billing_person_name*|": invoiceData["billingPersonFirstName"],
			"|*invoice_amount*|": invoiceData["totalAmount"],
			"|*invoice_number*|": invoiceData["invoiceNumber"],
		};
		var emailSubject = $("#emailSubject").val();
		var emailBody = $("#emailBody").text();
		
		for (var key in mapping) {
			var emailSubject = emailSubject.replace(key, mapping[key]);
			var emailBody = emailBody.replace(key, mapping[key]);
		}

		$("#emailSubject").val(emailSubject); 
		$("#sendTo").val(invoiceData["billingPersonEmail"]); 
		$("#sendToName").val(invoiceData["billingPersonName"]); 
		$("#clientId").val(invoiceData["clientId"]); 
		tinymce.get("emailBody").setContent(emailBody, { format: "html" });
		$("#emailPreview").modal("show");
	});

	$(".send-reminder").on("click", function() {
		var invoiceData = $(this).data("invoice-data");
		var mapping = {
			"|*project_name*|": invoiceData["projectName"],
			"|*term*|": invoiceData["monthName"],
			"|*year*|": invoiceData["year"],
			"|*billing_person_name*|": invoiceData["billingPersonFirstName"],
			"|*invoice_amount*|": invoiceData["invoiceAmount"],
			"|*invoice_number*|": invoiceData["invoiceNumber"],
		};
		var emailSubject = $("#emailSubject").val();
		var emailBody = $("#emailBody").text();
		
		for (var key in mapping) {
			var emailSubject = emailSubject.replace(key, mapping[key]);
			var emailBody = emailBody.replace(key, mapping[key]);
		}

		$("#emailSubject").val(emailSubject); 
		$("#sendTo").val(invoiceData["billingPersonEmail"]); 
		$("#sendToName").val(invoiceData["billingPersonName"]); 
		$("#invoiceId").val(invoiceData["invoiceId"]); 
		tinymce.get("emailBody").setContent(emailBody, { format: "html" });
		$("#emailPreview").modal("show");
	});

	$("#verifyInvoice").on("click", function () {
		if ($("#verifyInvoice").is(":checked")) {
			$("#sendInvoiceBtn").attr("disabled", false);
		} else {
			$("#sendInvoiceBtn").attr("disabled", true);
		}
	});
	
	$("#sendInvoiceForm").on("submit", function (event) {
		event.preventDefault();
		$("#sendInvoiceBtn").attr("disabled", true);
		if(validateFormData(event.target)) {
			event.target.submit();
		}
	});

	$("#sendInvoiceReminderForm").on("submit", function (event) {
		event.preventDefault();
		$("#sendBtn").attr("disabled", true);
		if(validateFormData(event.target)) {
			event.target.submit();
		}
	});
});

function validateFormData(form) {
	if (!form.checkValidity()) {
		form.reportValidity();
		return false;
	}
	return true;
}

function convert_number(number) {
	if (number < 0 || number > 999999999) {
		return "NUMBER OUT OF RANGE!";
	}
	var crore = Math.floor(number / 10000000);
	number -= crore * 10000000;
	var lakhs = Math.floor(number / 100000);
	number -= lakhs * 100000;
	var thousand = Math.floor(number / 1000);
	number -= thousand * 1000;
	var hundred = Math.floor(number / 100);
	number = number % 100;
	var tenths = Math.floor(number / 10);
	var one = Math.floor(number % 10);
	var result = "";
	if (crore > 0) {
		result += convert_number(crore) + " CRORE";
	}
	if (lakhs > 0) {
		result += (result == "" ? "" : " ") + convert_number(lakhs) + " LAKH";
	}
	if (thousand > 0) {
		result += (result == "" ? "" : " ") + convert_number(thousand) + " THOUSAND";
	}
	if (hundred) {
		result += (result == "" ? "" : " ") + convert_number(hundred) + " HUNDRED";
	}
	var ones = Array(
		"",
		"ONE",
		"TWO",
		"THREE",
		"FOUR",
		"FIVE",
		"SIX",
		"SEVEN",
		"EIGHT",
		"NINE",
		"TEN",
		"ELEVEN",
		"TWELVE",
		"THIRTEEN",
		"FOURTEEN",
		"FIFTEEN",
		"SIXTEEN",
		"SEVENTEEN",
		"EIGHTEEN",
		"NINETEEN"
	);
	var tens = Array(
		"",
		"",
		"TWENTY",
		"THIRTY",
		"FOURTY",
		"FIFTY",
		"SIXTY",
		"SEVENTY",
		"EIGHTY",
		"NINETY"
	);
	if (tenths > 0 || one > 0) {
		if (!(result == "")) {
			result += " AND ";
		}
		if (tenths < 2) {
			result += ones[tenths * 10 + one];
		}
		else {
			result += tens[tenths];
			if (one > 0) {
				result += "-" + ones[one];
			}
		}
	}
	if (result == "") {
		result = "ZERO";
	}
	return result;
}
$(function() {
	if ($(".show-modal")) {
		$(".show-modal").modal("show");
	}

	if ($("#financeReportRevenueTrends").length) {
		getData(
			{ type: "revenue-trend", filters: {} },
			financeReportRevenueTrendsReport
		);
	}
	if ($("#clientWiseReportRevenueTrends").length) {
		const clientId = $("#clientSelectBox option:selected").val();
		const startDate = $("#startDate").val();
		const endDate = $("#endDate").val();
		getData(
			{ 
				type: "revenue-trend-client-wise", 
				filters: {
					"client_id": clientId,
					"start_date": startDate,
					"end_date": endDate
				} 
			},
			clientWiseRevenueTrendsReport
		);
	}
});

function financeReportRevenueTrendsReport(reportsData) {
	const canvasElementId = "financeReportRevenueTrends";
	const labels = reportsData.labels;
	const currentPeriodTotalRevenue = reportsData.data.current_period_total_amount;
	const previousPeriodTotalRevenue = reportsData.data.previous_period_total_amount;
	const chartData = {
		labels: labels,
		datasets: [
			{
				label: "Previous Month Amount",
				backgroundColor: "rgb(255, 99, 132)",
				borderColor: "rgb(255, 99, 132)",
				data: reportsData.data.previous_period_client_data,
			},
			{
				label: "Current Month Amount",
				backgroundColor: "rgb(193, 242, 1)",
				borderColor: "rgb(193, 242, 1)",
				data: reportsData.data.current_period_client_data,
			}

		],
	};

	const chartConfig = {
		type: reportsData.graph_type || "bar",
		data: chartData,
		options: {
			categoryPercentage: 1.0,
			barPercentage: 0.8,
			maintainAspectRatio: true,
			indexAxis: "y",
			responsive: true,
			title: {
				display: true,
				text: "Total revenue this month: Rs. " + currentPeriodTotalRevenue
			},
			scales: {
				yAxes: [
					{
						barPercentage: 0.3,
						scaleLabel: {
							display: true,
							labelString: "Amount (In Rs)",
						}
					},
				],
				xAxes: [
					{
						scaleLabel: {
							display: false,
							labelString: "Client",
						},
						ticks: {
							callback: function(value,index, values) {
								const valueLength = value.length;
								const truncatedValue = value.substring(0, 15);
								return valueLength > 15 ? truncatedValue + "..." : truncatedValue;
							},
						}
					},
				]
			},
		}
	};

	new Chart(canvasElementId, chartConfig);
}

function clientWiseRevenueTrendsReport(reportsData) {
	const canvasElementId = "clientWiseReportRevenueTrends";
	const labels = reportsData.labels;
	const currentPeriodTotalRevenue = reportsData.data.total_amount;
	const chartData = {
		labels: labels,
		datasets: [
			{
				label: "Amount for month",
				backgroundColor: "rgb(255, 99, 132)",
				borderColor: "rgb(0,0,0)",
				data: reportsData.data.amount,
			}
		],
	};

	const chartConfig = {
		type: reportsData.graph_type || "bar",
		data: chartData,
		options: {
			categoryPercentage: 1.0,
			barPercentage: 0.8,
			maintainAspectRatio: true,
			indexAxis: "y",
			responsive: true,
			title: {
				display: true,
				text: "Total revenue: Rs. " + currentPeriodTotalRevenue
			},
			scales: {
				yAxes: [
					{
						barPercentage: 0.3,
						scaleLabel: {
							display: true,
							labelString: "Amount (In Rs)",
						}
					},
				],
				xAxes: [
					{
						scaleLabel: {
							display: true,
							labelString: "Month",
						}
					},
				]
			},
			"animation": {
				"onComplete": function() {
					const chartInstance = this.chart,
					ctx = chartInstance.ctx;

					ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize,
														Chart.defaults.global.defaultFontStyle,
														Chart.defaults.global.defaultFontFamily);
					ctx.textAlign = 'center';
					ctx.textBaseline = 'bottom';

					this.data.datasets.forEach(function(dataset, i) {
						const meta = chartInstance.controller.getDatasetMeta(i);
						meta.data.forEach(function(bar, index) {
							const data = dataset.data[index];
							ctx.fillText(data, bar._model.x, bar._model.y - 5);
						});
					});
				}
			},
		}
	};

	new Chart(canvasElementId, chartConfig);
}

function getData(params, callback) {
	url = $("#get_report_data_url").val();
	axios.get(url, { params }).then((res) => callback(res.data));
}

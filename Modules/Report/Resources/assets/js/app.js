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
	if ($("#userDashboardGraph").length) {
		getData(
			{ type: "fte-trend" },
			userFteTrendsReport
		);
	}
	if ($("#clientChart").length) {
		clientOnboardingAnalytics()
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

					ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
					ctx.textAlign = "center";
					ctx.textBaseline = "bottom";

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

function userFteTrendsReport(reportFteData) {
	const canvasElementId = "userDashboardGraph";
	const labels = reportFteData.labels;
	const chartData = {
		labels: labels,
		datasets: [
			{
				label: "Fte",
				backgroundColor: "rgb(255, 0, 0)",
				borderColor: "rgb(105, 105, 105)",
				data: reportFteData.data,
			},
		],
	};

	const chartConfig = {
		type: reportFteData.graph_type || "bar",
		data: chartData,
		options: {
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero: true,
					}
				}]
			}	
		}
	};

	new Chart(canvasElementId, chartConfig);
}

function clientOnboardingAnalytics(){
	var clients =JSON.parse($("input[name='clients']").val());
    var months = [];
    var counts = [];
    clients.forEach(function(client) {
        var month = new Date(client.created_at).toLocaleString('default', { month: 'long' });
        if (!months.includes(month)) {
            months.push(month);
            counts.push(1);
        } else {
            var index = months.indexOf(month);
            counts[index]++;
        }
    });

    var ctx = document.getElementById('clientChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Client Count',
                data: counts,
                backgroundColor: 'rgba(75, 192, 192, 0.2)', 
                borderColor: 'rgba(75, 192, 192, 1)', 
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1
                }
            }
        }
    });

    var dataFilter = document.getElementById('dataFilter');
    dataFilter.addEventListener('change', function() {
        var filterBy = dataFilter.value;
        var filteredMonths = [];
        var filteredCounts = [];
        if (filterBy === 'date') {
            clients.forEach(function(client) {
                var date = new Date(client.created_at).toLocaleDateString();
                if (!filteredMonths.includes(date)) {
                    filteredMonths.push(date);
                    filteredCounts.push(1);
                } else {
                    var index = filteredMonths.indexOf(date);
                    filteredCounts[index]++;
                }
            });
        } else if (filterBy === 'month') {
            clients.forEach(function(client) {
                var month = new Date(client.created_at).toLocaleString('default', { month: 'long' });
                if (!filteredMonths.includes(month)) {
                    filteredMonths.push(month);
                    filteredCounts.push(1);
                } else {
                    var index = filteredMonths.indexOf(month);
                    filteredCounts[index]++;
                }
            });
        } else if (filterBy === 'year') {
            clients.forEach(function(client) {
                var year = new Date(client.created_at).getFullYear();
                if (!filteredMonths.includes(year)) {
                    filteredMonths.push(year);
                    filteredCounts.push(1);
                } else {
                    var index = filteredMonths.indexOf(year);
                    filteredCounts[index]++;
                }
            });
        }

        chart.data.labels = filteredMonths;
        chart.data.datasets[0].data = filteredCounts;
        chart.update();
    });
}

function getData(params, callback) {
	url = $("#get_report_data_url").val();
	axios.get(url, { params }).then((res) => callback(res.data));
}

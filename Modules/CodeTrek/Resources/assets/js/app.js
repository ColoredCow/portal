$(function () {
	$("#CodeTrekApplicationReport").length;
	{
		const startDate = $("#start_date").val();
		const endDate = $("#end_date").val();

		getData(
			{
				type: "codetrek-application",
				filters: {
					start_date: startDate,
					end_date: endDate,
				},
			},
			CodeTrekApplicationsReport
		);
	}
});

function CodeTrekApplicationsReport(applicantsGraph) {
	const canvasElementId = "CodeTrekApplicationReport";
	const labels = applicantsGraph.dates;
	const chartData = {
		labels: labels,
		datasets: [
			{
				label: [],
				data: applicantsGraph.counts,
				backgroundColor: "rgba(52, 144, 220)",
				borderColor: "rgba(52, 144, 220)",
			},
		],
	};

	const chartConfig = {
		type: applicantsGraph.graph_type || "bar",
		data: chartData,
		options: {
			barPercentage: 0.8,
			maintainAspectRatio: true,
			responsive: true,
			scales: {
				yAxes: [
					{
						ticks: {
							beginAtZero: true,
							stepSize: 1,
						},
					},
				],
				xAxes: [
					{
						scaleLabel: {
							display: true,
						},
						ticks: {
							callback: function (value, index, values) {
								const valueLength = value.length;
								const truncatedValue = value.substring(0, 15);
								return valueLength > 15
									? truncatedValue + "..."
									: truncatedValue;
							},
						},
					},
				],
			},
		},
	};

	new Chart(canvasElementId, chartConfig);
}

function getData(params, callback) {
	url = $("#get_report_data_url").val();
	axios
		.get(url, { params })
		.then((res) => callback(res.data))
		.catch((error) => console.error("Error retrieving data:", error));
}

$(function () {
	$("#CodeTrekApplicationReportMonthly").length;
	{
		getMonthlyData(CodeTrekApplicationsReportMonthly);
	}
});

function getMonthName(monthNumber) {
	const monthNames = [
		"Jan",
		"Feb",
		"Mar",
		"Apr",
		"May",
		"Jun",
		"Jul",
		"Aug",
		"Sep",
		"Oct",
		"Nov",
		"Dec",
	];
	return monthNames[monthNumber - 1];
}

function CodeTrekApplicationsReportMonthly(applicantsGraph) {
	const canvasElementId = "CodeTrekApplicationReportMonthly";
	const labels = applicantsGraph.labels.map((label) => {
		const [year, month] = label.split("-");
		return `${getMonthName(parseInt(month))}-${year}`;
	});
	const data = applicantsGraph.data;

	const chartDataMonthly = {
		labels: labels,
		datasets: [
			{
				label: "Monthly Data",
				data: data,
				backgroundColor: "rgba(52, 144, 220)",
				borderColor: "rgba(52, 144, 220)",
			},
		],
	};

	const chartConfig = {
		type: applicantsGraph.graph_type || "bar",
		data: chartDataMonthly,
		options: {
			barPercentage: 0.8,
			maintainAspectRatio: true,
			responsive: true,
			scales: {
				xAxes: [
					{
						ticks: {
							callback: function (value, index, values) {
								return value;
							},
						},
					},
				],
				yAxes: [
					{
						ticks: {
							beginAtZero: true,
							stepSize: 1,
						},
					},
				],
			},
			tooltips: {
				callbacks: {
					label: function (tooltipItem, data) {
						const count = tooltipItem.yLabel;
						return `:${count}`;
					},
				},
			},
		},
	};

	new Chart(canvasElementId, chartConfig);
}

function getMonthlyData(callback) {
	url = $("#monthly_tab_nav_item").data("route");
	axios
		.get(url)
		.then((res) => callback(res.data))
		.catch((error) => console.error("Error retrieving data:", error));
}

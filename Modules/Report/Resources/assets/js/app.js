$(function() {
  if ($(".show-modal")) {
    $(".show-modal").modal("show");
  }

  if ($("#financeReportRevenueTrends").length) {
    getData({ type: "abc", filters: {} }, financeReportRevenueTrendsReport);
  }
});

function financeReportRevenueTrendsReport(reportsData) {
  const canvasElementId = "financeReportRevenueTrends";
  const labels = [
    "April (2022)",
    "May (2022)",
    "June (2022)",
    "July (2022)",
    "August (2022)",
    "September (2022)",
    "October (2022)",
    "November (2022)",
    "December (2022)",
    "January (2023)",
    "February (2023)",
    "March (2023)",
  ];

  const data = {
    labels: labels,
    datasets: [
      {
        label: "Revenue Trends",
        backgroundColor: "rgb(255, 99, 132)",
        borderColor: "rgb(255, 99, 132)",
        data: [11, 12, 15, 20, 23, 35, 40, 45, 48, 52, 55, 58],
      },
    ],
  };

  const config = {
    type: "bar",
    data: data,
    options: {
      responsive: true,
      scales: {
        xAxes: [
          {
            barPercentage: 0.4,
            scaleLabel: {
              display: true,
              labelString: "months",
            },
          },
        ],
        yAxes: [
          {
            scaleLabel: {
              display: true,
              labelString: "Rs (In Lacks)",
            },
          },
        ],
      },
    },
  };

  new Chart(canvasElementId, config);
}

function getData(params, callback) {
  url = $("#get_report_data_url").val();
  axios.get(url, { params }).then((res) => callback(res.data));
}

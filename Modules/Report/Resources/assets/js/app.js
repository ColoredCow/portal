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
});

function financeReportRevenueTrendsReport(reportsData) {
  const canvasElementId = "financeReportRevenueTrends";
  const labels = reportsData.labels;

  const data = {
    labels: labels,
    datasets: [
      {
        label: "Revenue Trends",
        backgroundColor: "rgb(255, 99, 132)",
        borderColor: "rgb(255, 99, 132)",
        data: reportsData.data,
      },
    ],
  };

  const config = {
    type: reportsData.graph_type || "bar",
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

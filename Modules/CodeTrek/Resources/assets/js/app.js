$(function() {
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
        // borderWidth: 10,
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
              callback: function(value, index, values) {
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

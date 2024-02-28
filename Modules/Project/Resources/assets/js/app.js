$(document).ready(function () {
    $("input").on("change", function () {
        this.value = this.value.replace(/\s+/g, " ");
    });

    window.setTimeout(function() {
        $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
            $(this).remove(); 
        });
    }, 6000);

    var chartContainer = $("#chartContainer");
    console.log("hello", chartContainer);

    var chart = new CanvasJS.Chart(chartContainer.attr("id"), {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light1",
        title: {
            text: "Most Number of Centuries across all Formats till 2017"
        },
        axisX: {
            reversed: true
        },
        axisY: {
            includeZero: true
        },
        toolTip: {
            shared: true
        },
        data: [{
            type: "stackedBar",
            name: "Test",
            dataPoints: JSON.parse(chartContainer.data("test"))
        },{
            type: "stackedBar",
            name: "ODI",
            dataPoints: JSON.parse(chartContainer.data("odi"))
        },{
            type: "stackedBar",
            name: "T20",
            indexLabel: "#total",
            indexLabelPlacement: "outside",
            indexLabelFontSize: 15,
            indexLabelFontWeight: "bold",
            dataPoints: JSON.parse(chartContainer.data("t20"))
        }]
    });

    chart.render();
});

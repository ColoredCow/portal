document.addEventListener('DOMContentLoaded', function() {
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
});
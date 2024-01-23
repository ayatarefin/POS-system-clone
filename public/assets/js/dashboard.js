$(function () {
    // Function to create or update the cumulative sales chart
    function createOrUpdateCumulativeSalesChart(dates, cumulativeTotals) {
        var cumulativeSalesChart = new ApexCharts(document.querySelector("#chart"), {
            series: [
                { name: "Total Sale:", data: cumulativeTotals },
            ],
            chart: {
                type: "bar",
                height: 345,
                offsetX: -15,
                toolbar: { show: true },
                foreColor: "#adb0bb",
                fontFamily: 'inherit',
                sparkline: { enabled: false },
            },
            colors: ["#5D87FF", "#49BEFF"],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "55%",
                    borderRadius: [6],
                    borderRadiusApplication: 'end',
                    borderRadiusWhenStacked: 'all'
                },
            },
            markers: { size: 0 },
            dataLabels: { enabled: false },
            legend: { show: false },
            grid: {
                borderColor: "rgba(0,0,0,0.1)",
                strokeDashArray: 3,
                xaxis: {
                    lines: { show: false },
                },
            },
            xaxis: {
                type: "category",
                categories: dates,
                labels: { style: { cssClass: "grey--text lighten-2--text fill-color" } },
            },
            yaxis: {
                show: true,
                min: 0,
                max: Math.max(...cumulativeTotals),
                tickAmount: 4,
                labels: { style: { cssClass: "grey--text lighten-2--text fill-color" } },
            },
            stroke: {
                show: true,
                width: 3,
                lineCap: "butt",
                colors: ["transparent"],
            },
            tooltip: { theme: "light" },
            responsive: [
                {
                    breakpoint: 600,
                    options: {
                        plotOptions: { bar: { borderRadius: 3 } },
                    }
                }
            ]
        });

        cumulativeSalesChart.render();
    }
    // Event listener for the button click
    $("#generateChart").on("click", function () {
        dailySaleChart();
    });

    // Function to make AJAX request and update cumulative sales chart
    dailySaleChart = () => {
        var datetime = $("input[name='datetime']").val();
        var todatetime = $("input[name='todatetime']").val();
        var itemName = $("select[name='itemName']").val();

        if (datetime == null) {
            actionError('From Date');
            return;
        }
        if (todatetime < datetime) {
            actionError('Valid Date');
            return;
        }
        if (itemName == null) {
            actionError('Product');
        }

        // AJAX request
        $.ajax({
            url: '/fetch-chart-data',
            method: 'GET',
            data: {
                fromdate: datetime,
                todate: todatetime,
                itemName: itemName
            },
            success: function (response) {
                // Update Cumulative Sales Chart data
                createOrUpdateCumulativeSalesChart(response.dates, response.cumulativeTotals);
            },
            error: function (error) {
                console.error('Error fetching data:', error);
            }
        });
    };
});

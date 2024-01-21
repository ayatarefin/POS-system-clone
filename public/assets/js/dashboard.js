
$(function () {
    // =====================================
    // Profit
    // =====================================
    var productList = [];
    for (var i = 30; i < 390; i += 12) {
        productList.push(i);
    }

    var profitChart = new ApexCharts(document.querySelector("#chart"), {
        series: [
            { name: "Total Sale:", data: productList },
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
            categories: productList,
            labels: { style: { cssClass: "grey--text lighten-2--text fill-color" } },
        },
        yaxis: {
            show: true,
            min: 0,
            max: 400,
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

    profitChart.render();
    // Function to create or update the sales chart
    function createOrUpdateSalesChart(dates, saleQty) {
        var salesChart = new ApexCharts(document.querySelector("#chart"), {
            series: [
                { name: "Total Sale:", data: saleQty },
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
                max: Math.max(...saleQty),
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

        salesChart.render();
    }

    // Call the dailySaleChart function
    dailySaleChart = () => {
        var datetime = $("input[name='datetime']").val();
        var todatetime = $("input[name='todatetime']").val();
        var itemName = $("select[name='itemName']").val();

        // Validation checks (if needed)

        // AJAX request
        console.log('Before AJAX request');
        $.ajax({
            url: '/fetch-chart-data',
            method: 'GET',
            data: {
                fromdate: datetime,
                todate: todatetime,
                itemName: itemName
            },
            success: function (response) {
                console.log('AJAX success');
                // Update Sales Chart data
                createOrUpdateSalesChart(response.dates, response.saleQty);

                // Assuming other chart updates follow a similar pattern
            },
            error: function (error) {
                console.error('Error fetching data:', error);
            }
        });

    };
});

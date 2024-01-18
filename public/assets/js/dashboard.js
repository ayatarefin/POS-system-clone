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

// =====================================
// Breakup Chart
// =====================================
var breakupChart = new ApexCharts(document.querySelector("#breakup"), {
color: "#adb5bd",
series: [38, 40, 25],
labels: ["2022", "2021", "2020"],
chart: {
width: 180,
type: "donut",
fontFamily: "Plus Jakarta Sans', sans-serif",
foreColor: "#adb0bb",
},
plotOptions: {
pie: {
startAngle: 0,
endAngle: 360,
donut: { size: '75%' },
},
},
stroke: { show: false },
dataLabels: { enabled: false },
legend: { show: false },
colors: ["#5D87FF", "#ecf2ff", "#F9F9FD"],
responsive: [
{
breakpoint: 991,
options: { chart: { width: 150 } },
},
],
tooltip: { theme: "dark", fillSeriesColor: false },
});

breakupChart.render();

// =====================================
// Earning Chart
// =====================================
var earningChart = new ApexCharts(document.querySelector("#earning"), {
chart: {
id: "sparkline3",
type: "area",
height: 60,
sparkline: { enabled: true },
group: "sparklines",
fontFamily: "Plus Jakarta Sans', sans-serif",
foreColor: "#adb0bb",
},
series: [
{ name: "Earnings", color: "#49BEFF", data: [25, 66, 20, 40, 12, 58, 20] },
],
stroke: { curve: "smooth", width: 2 },
fill: { colors: ["#f3feff"], type: "solid", opacity: 0.05 },
markers: { size: 0 },
tooltip: { theme: "dark", fixed: { enabled: true, position: "right" }, x: { show: false } },
});

earningChart.render();
});

// Call the dailySaleChart function
dailySaleChart = () => {
    var datetime = $("input[name='datetime']").val();
    var todatetime = $("input[name='todatetime']").val();
    var itemName = $("select[name='itemName']").val();

    // Validation checks (if needed)

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
            // Assuming the response is in the format expected by your chart library

            // Update Profit Chart data
            profitChart.updateSeries([{ data: response.arrSale }]);

            // Update Breakup Chart data
            breakupChart.updateOptions({
                series: response.breakupSeries,
                labels: response.breakupLabels
            });

            // Update Earning Chart data
            earningChart.updateSeries([{ data: response.earningData }]);
        },
        error: function (error) {
            console.error('Error fetching data:', error);
        }
    });
};

// Your chart initialization code here



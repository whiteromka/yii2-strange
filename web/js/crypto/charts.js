let clickedAltoins = ['btc'];

$(function() {
    getData('btc');

    $('.js-altcoin').on('click', function() {
        let altcoin = $(this).attr('data-altcoin');
        if (!clickedAltoins.includes(altcoin)) {
            clickedAltoins.push(altcoin);
            getData(altcoin);
        }
    });
});

function getData(altcoin = null) {
    let url = altcoin ? '/crypto/get-data-charts?altcoin='+altcoin : '/crypto/get-data-charts';
    $.post(url).done(function(data) {
        if (data.success) {
            drawCharts(data.data)
        }
    });
}

function drawCharts(data) {
    for (altcoin in data) {
        let selector = 'chartdiv-' + altcoin;
        chart(selector, data[altcoin]);
    }
}

function chart(selector, data) {
    am4core.ready(function() {
        am4core.useTheme(am4themes_animated);  // Themes begin
        let chart = am4core.create(selector, am4charts.XYChart);  // Create chart instance
        chart.data = data;    // Add data
        chart.dateFormatter.inputDateFormat = "dd.MM.yyyy"; // Set input format for the dates

        // Create axes
        let dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        // Create series
        let series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "value";
        series.dataFields.dateX = "date";
        series.tooltipText = "{value}"
        series.strokeWidth = 2;
        series.minBulletDistance = 15;

        // Drop-shaped tooltips
        series.tooltip.background.cornerRadius = 20;
        series.tooltip.background.strokeOpacity = 0;
        series.tooltip.pointerOrientation = "vertical";
        series.tooltip.label.minWidth = 40;
        series.tooltip.label.minHeight = 40;
        series.tooltip.label.textAlign = "middle";
        series.tooltip.label.textValign = "middle";

        // Make bullets grow on hover
        let bullet = series.bullets.push(new am4charts.CircleBullet());
        bullet.circle.strokeWidth = 2;
        bullet.circle.radius = 4;
        bullet.circle.fill = am4core.color("#fff");

        let bullethover = bullet.states.create("hover");
        bullethover.properties.scale = 1.3;

        // Make a panning cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "panXY";
        chart.cursor.xAxis = dateAxis;
        chart.cursor.snapToSeries = series;

        // Create vertical scrollbar and place it before the value axis
        chart.scrollbarY = new am4core.Scrollbar();
        chart.scrollbarY.parent = chart.leftAxesContainer;
        chart.scrollbarY.toBack();

        // Create a horizontal scrollbar with previe and place it underneath the date axis
        chart.scrollbarX = new am4charts.XYChartScrollbar();
        chart.scrollbarX.series.push(series);
        chart.scrollbarX.parent = chart.bottomAxesContainer;

        dateAxis.start = 0.79;
        dateAxis.keepSelection = true;
    });
}



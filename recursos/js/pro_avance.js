function cargarGrafica(categoriesParam, seriesParam){
    Highcharts.chart('report_view', {
        title: {
            text: 'Avance del proyecto',
            x: -20 //center
        },
        xAxis: {
            categories: categoriesParam
        },
        yAxis: {
            title: {
                text: 'Tiempo de desarrollo'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ' horas'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: seriesParam
    });
}
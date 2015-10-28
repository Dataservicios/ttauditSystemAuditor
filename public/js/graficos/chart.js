function creaGraficoDonut(data,div) {
		var chartData=data;
		  	var chart;
		  	// SERIAL CHART
		  	// title of the chart
		  		chart = new AmCharts.AmPieChart();
                //chart.addTitle("Visitors countries", 16);
// GRAPHS
                chart.colorField = "color";
                chart.dataProvider = chartData;
                chart.titleField = "tipo";
                chart.valueField = "cantidad";
                chart.sequencedAnimation = true;
                chart.startEffect = "elastic";
                chart.percentPrecision=0;
                chart.innerRadius = "70%";
                chart.startDuration = 2;
                chart.labelRadius = 15;
                chart.balloonText = "[<span style='font-size:14px'>([[percents]]%)</span>";
                // the following two lines makes the chart 3D
               // chart.depth3D = 10;
                //chart.angle = 15;

            chart.write(div);

 	}

/**
 *
 * @param data
 * @param div
 * @param legend bolean true false
 */
function creaGraficoPie(data,div,legenda) {
    var chartData=data;
    var chart;
    // SERIAL CHART
    // title of the chart
    chart = new AmCharts.AmPieChart();
    //chart.addTitle("Visitors countries", 16);
// GRAPHS
    chart.colorField = "color";
    chart.dataProvider = chartData;
    chart.labelText = "[[percents]]%";
    chart.titleField = "tipo";
    chart.valueField = "cantidad";
    chart.sequencedAnimation = true;
    chart.startEffect = "elastic";
    chart.percentPrecision=0;
    //chart.innerRadius = "70%";
    chart.startDuration = 2;
    chart.labelRadius = 15;
    chart.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>";
    // the following two lines makes the chart 3D
    // chart.depth3D = 10;
    //chart.angle = 15;

    // LEGEND
    if(legenda ){
        legend = new AmCharts.AmLegend();
        legend.align = "center";
        //legend.labelWidth= 105;
        legend.marginRight = 27;
        legend.maxColumns=8;
        legend.valueText="[[cantidad]]";
        legend.valueWidth = 30 ;
        //legend.valueText="[[value]]";
        //legend.valueField="";
        //legend.markerType = "circle";
        //chart.balloonText = "[[title]]<br><span style='font-size:12px'><b>[[value]]</b> ([[percents]]%)</span>";
        chart.addLegend(legend);
    }
    chart.write(div);

}
// Function creaGraficoColumnas
// PARAMETROS
//---------------------------------------
// data : tipo objeto json con propiedad respuesta.
// div: nombre de la capa o div en donde se mostrara el grafico por html
// rotation: Tipo Bool, muestra la orientación del lgráfico, horizontal o vertical
// tamano : Tipo entero. Extrae un tamaño determinado de caracteres que luego mostrará en el eje X
 function creaGraficoColumnas(data,div, rotation,tamano ) {

        //  manipulaData(data);
        //  var chartData= data;

		    var chartData;
            if(tamano== undefined ||  tamano == null   ) {
                chartData = data
            } else {
                chartData= manipulaData(data,tamano);
            }

		  	var chart;
		  	// SERIAL CHART
		  	// title of the chart
		  		chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.categoryField = "respuesta";
                // this single line makes the chart a bar chart,
                // try to set it to false - your bars will turn to columns
                 if(rotation ==true) {
                     chart.rotate = true;
                 } else {
                     chart.rotate = false;
                 }
                //chart.rotate = true;
                // the following two lines makes chart 3D
                // chart.depth3D = 20;
                // chart.angle = 30;
                // AXES
                // Category
                var categoryAxis = chart.categoryAxis;
                 categoryAxis.labelRotation = 45;
                categoryAxis.gridPosition = "start";
                categoryAxis.axisColor = "#DADADA";
                categoryAxis.fillAlpha = 1;
                categoryAxis.gridAlpha = 0;
                categoryAxis.fillColor = "#FAFAFA";
                //categoryAxis.labelsEnabled = false;
                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.axisColor = "#DADADA";
                //valueAxis.title = "Income in millions, USD";
                valueAxis.gridAlpha = 0.1;
                chart.addValueAxis(valueAxis);

                // GRAPH
                var graph = new AmCharts.AmGraph();
                graph.title = "cantidad";
                graph.valueField = "cantidad";
                graph.type = "column";

                graph.labelPosition = "middle";
                graph.labelText = "[[value]] ([[porcentaje]]%)";
                graph.balloonText = "[[category]]: [[value]]  ([[porcentaje]]%)";
                graph.lineAlpha = 0;
                graph.fillColors = "#009B3A";
                graph.fillAlphas = 1;
                chart.addGraph(graph);
                // // LEGEND                  
                // var legend = new AmCharts.AmLegend();
                // legend.borderAlpha = 0.2;
                // legend.horizontalGap = 10;
                // chart.addLegend(legend);

                // chart.creditsPosition = "top-right";

            chart.write(div);
    }

function creaGraficoColumnasPorcentajes(data,div) {
    var chartData=data;
    var chart;
    // SERIAL CHART
    // title of the chart
    chart = new AmCharts.AmSerialChart();
    chart.dataProvider = chartData;
    chart.categoryField = "tipo";
    chart.plotAreaBorderAlpha = 0.2;
    chart.rotate = true;

    console.log(chartData[0].length);
    $.each(chartData[0], function(indice, nombre){
        console.log(' >', indice + '.' + nombre);
    });
//AXES
    // category
    var categoryAxis = chart.categoryAxis;
    categoryAxis.gridAlpha = 0.1;
    categoryAxis.axisAlpha = 0;
    categoryAxis.gridPosition = "start";

    // value
    var valueAxis = new AmCharts.ValueAxis();
    valueAxis.stackType = "regular";
    valueAxis.gridAlpha = 0.1;
    valueAxis.axisAlpha = 0;
    chart.addValueAxis(valueAxis);
    // value
    var valueAxis = new AmCharts.ValueAxis();
    valueAxis.axisColor = "#DADADA";
    //valueAxis.title = "Income in millions, USD";
    valueAxis.gridAlpha = 0.1;
    chart.addValueAxis(valueAxis);

    var graph = new AmCharts.AmGraph();
    graph.title = "bodega";
    graph.labelText = "[[percents]]%";
    graph.valueField = "bodega";
    graph.type = "column";
    graph.lineAlpha = 0;
    graph.fillAlphas = 1;
    graph.lineColor = "#D8E0BD";
    graph.balloonText = "<span style='color:#555555;'>[[category]]</span><br><span style='font-size:14px'>[[title]]:<b>[[value]]</b></span>";
    chart.addGraph(graph);
    // GRAPH


    // third graph
    graph = new AmCharts.AmGraph();
    graph.title = "locutorio";
    graph.labelText = "[[percents]]%";
    graph.valueField = "locutorio";
    graph.type = "column";
    graph.lineAlpha = 0;
    graph.fillAlphas = 1;
    graph.lineColor = "#B3DBD4";
    graph.balloonText = "<span style='color:#555555;'>[[category]]</span><br><span style='font-size:14px'>[[title]]:<b>[[value]]</b></span>";
    chart.addGraph(graph);
    // // LEGEND
    // var legend = new AmCharts.AmLegend();
    // legend.borderAlpha = 0.2;
    // legend.horizontalGap = 10;
    // chart.addLegend(legend);

    // chart.creditsPosition = "top-right";

    chart.write(div);
}

function creaGraficoColumnasPorcentajesDinamic(data,div, activelegend , rotation) {
    var chartData=data;
    var chart;
    // SERIAL CHART
    // title of the chart
    chart = new AmCharts.AmSerialChart();
    chart.dataProvider = chartData;
    chart.percentPrecision=0;
    chart.categoryField = "tipo";
    chart.plotAreaBorderAlpha = 0.2;
    if(rotation ==true) {
        chart.rotate = true;
    }
    //

    console.log(chartData[0].length);

//AXES
    // category
    var categoryAxis = chart.categoryAxis;
    categoryAxis.gridAlpha = 0.1;
    categoryAxis.axisAlpha = 0;
    categoryAxis.gridPosition = "start";

    // value
    var valueAxis = new AmCharts.ValueAxis();
    valueAxis.stackType = "regular";
    valueAxis.gridAlpha = 0.1;
    valueAxis.axisAlpha = 0;
    chart.addValueAxis(valueAxis);
    // value
    var valueAxis = new AmCharts.ValueAxis();
    valueAxis.axisColor = "#DADADA";
    //valueAxis.title = "Income in millions, USD";
    valueAxis.gridAlpha = 0.1;
    chart.addValueAxis(valueAxis);

    var graph;
    var i=0;
    var colores = ["#009B3A","#FFC000","#DC0451","#00ADD0","#C72C95", "#D8E0BD", "#B3DBD4", "#69A55C", "#B5B8D3", "#F4E23B","#000000"];
    console.log(colores);
    $.each(chartData[0], function(indice, valor){
        i++;
        if (i > 1) {
            console.log(' >', indice + '.' + valor);
            graph= new AmCharts.AmGraph();
            graph.title = indice;
            graph.labelText = "[[value]] ([[percents]]%)";
            graph.valueField = indice;
            graph.type = "column";
            graph.lineAlpha = 0;
            graph.fillAlphas = 1;
            graph.lineColor = colores[i];
            graph.balloonText = "<span style='color:#555555 ;font-size:14px '>[[category]]</span><br><span style='font-size:12px'>[[title]]:<b>[[value]]</b></span>";
            chart.addGraph(graph);
        }

        // GRAPH
    });


    // // LEGEND
    if (activelegend==true) {
        var legend = new AmCharts.AmLegend();
        legend.borderAlpha = 0.2;
        legend.horizontalGap = 10;
        chart.addLegend(legend);
        chart.creditsPosition = "top-right";
    }


    chart.write(div);
}



//Modificando el tamaño de la data de entrada  eje x
// PARAMETROS
// data : tipo objeto json con propiedad respuesta.
// extrae : Tipo entero Extrae un tamaño determinado de caracteres
function manipulaData (data, tamano ){

    for (var i=0; i<data.length; i++) {
        var nuevoData = data[i].respuesta.substring(0,tamano)
        if (data[i].respuesta.length > tamano) {
            data[i].respuesta = nuevoData + " ...";;
        } else {
            data[i].respuesta = nuevoData;
        }

    }

    return data;
}
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
   // chart.addTitle("Visitors countries", 16);
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

        legend.marginBottom= -1;
        legend.position ="left";
        //legend.valueWidth = 30 ;
        //legend.valueText="[[value]]";
        //legend.valueField="";
        //legend.markerType = "circle";
        //chart.balloonText = "[[title]]<br><span style='font-size:12px'><b>[[value]]</b> ([[percents]]%)</span>";
        chart.addLegend(legend);
    }
    chart.write(div);

}


/**
 *Function creaGraficoColumnas
 * @param {Obj Json} data - tipo objeto json con propiedad respuesta
 * @param {String} div - nombre de la capa o div en donde se mostrara el grafico por html
 * @param {bool} rotation -  muestra la orientación del lgráfico, horizontal o vertical
 * @param {Integer} tamano - Extrae un tamaño determinado de caracteres que luego mostrará en el eje X
 * @param {Integer} escala_min - Escala mínima de incio eje Y
 * @param {Integer} escala_max - Escala máxima de incio eje Y
 */
 function creaGraficoColumnas(data,div, rotation,tamano, escala_min, escala_max ) {

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

                //
                if(escala_min != undefined) valueAxis.minimum = escala_min;

                if(escala_max != undefined) valueAxis.maximum = escala_max ;


     //valueAxis.minimum = 0;
     //valueAxis.maximum = 100 ;

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

/**
 *Function creaGraficoColumnas
 * @param {Obj Json} data - tipo objeto json con propiedad respuesta
 * @param {String} div - nombre de la capa o div en donde se mostrara el grafico por html
 * @param {bool} rotation -  muestra la orientación del lgráfico, horizontal o vertical
 * @param {Integer} tamano - Extrae un tamaño determinado de caracteres que luego mostrará en el eje X
 * @param {Integer} escala_min - Escala mínima de incio eje Y
 * @param {Integer} escala_max - Escala máxima de incio eje Y
 */
function creaGraficoColumnasComparacion(data,div, rotation,tamano,escala_min, escala_max  ) {

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

// SERIAL CHART
    chart = new AmCharts.AmSerialChart();
    chart.dataProvider = chartData;
    chart.categoryField = "ola";
    chart.startDuration = 1;
    chart.plotAreaBorderColor = "#DADADA";
    chart.plotAreaBorderAlpha = 1;
    // this single line makes the chart a bar chart

    if(rotation ==true) {
        chart.rotate = true;
    } else {
        chart.rotate = false;
    }
    // AXES
    // Category
    var categoryAxis = chart.categoryAxis;
    categoryAxis.gridPosition = "start";
    categoryAxis.gridAlpha = 0.1;
    categoryAxis.axisAlpha = 0;

    // Value
    var valueAxis = new AmCharts.ValueAxis();
    valueAxis.axisAlpha = 0;
    valueAxis.gridAlpha = 0.1;
   // valueAxis.position = "top";
    if(escala_min != undefined) valueAxis.minimum = escala_min;

    if(escala_max != undefined) valueAxis.maximum = escala_max ;
    chart.addValueAxis(valueAxis);

    // GRAPHS
    // first graph
    var graph1 = new AmCharts.AmGraph();
    graph1.type = "column";
    graph1.title = "Disponible";
    graph1.valueField = "Disponible";
    graph1.balloonText = "Disponible:[[value]] %";
    graph1.labelText = "[[value]] %";
    graph1.lineAlpha = 0;
    graph1.fillColors = "#009B3A";
    graph1.fillAlphas = 1;
    chart.addGraph(graph1);

    // second graph
    var graph2 = new AmCharts.AmGraph();
    graph2.type = "column";
    graph2.title = "No Disponible";
    graph2.valueField = "No Disponible";
    graph2.balloonText = "No Disponible:[[value]] %";
    graph2.labelText = "[[value]]  %";
    graph2.lineAlpha = 0;
    graph2.fillColors = "#81acd9";
    graph2.fillAlphas = 1;
    chart.addGraph(graph2);

    // LEGEND
    var legend = new AmCharts.AmLegend();
    chart.addLegend(legend);

    //chart.creditsPosition = "top-right";

    // WRITE
    chart.write(div);
}

function creaGraficoColumnasComparacionTransaccion(data,div, rotation,tamano, escala_min, escala_max  ) {

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

// SERIAL CHART
    chart = new AmCharts.AmSerialChart();
    chart.dataProvider = chartData;
    chart.categoryField = "ola";
    chart.startDuration = 1;
    chart.plotAreaBorderColor = "#DADADA";
    chart.plotAreaBorderAlpha = 1;
    // this single line makes the chart a bar chart

    if(rotation ==true) {
        chart.rotate = true;
    } else {
        chart.rotate = false;
    }
    // AXES
    // Category
    var categoryAxis = chart.categoryAxis;
    categoryAxis.gridPosition = "start";
    categoryAxis.gridAlpha = 0.1;
    categoryAxis.axisAlpha = 0;

    // Value
    var valueAxis = new AmCharts.ValueAxis();
    valueAxis.axisAlpha = 0;
    valueAxis.gridAlpha = 0.1;
    if(escala_min != undefined) valueAxis.minimum = escala_min;

    if(escala_max != undefined) valueAxis.maximum = escala_max ;
    // valueAxis.position = "top";
    chart.addValueAxis(valueAxis);

    // GRAPHS
    // first graph
    var graph1 = new AmCharts.AmGraph();
    graph1.type = "column";
    graph1.title = "Con Exito";
    graph1.valueField = "Con Exito";
    graph1.balloonText = "Con Exito:[[value]] %";
    graph1.labelText = "[[value]] %";
    graph1.lineAlpha = 0;
    graph1.fillColors = "#009B3A";
    graph1.fillAlphas = 1;
    chart.addGraph(graph1);

    // second graph
    var graph2 = new AmCharts.AmGraph();
    graph2.type = "column";
    graph2.title = "Sin Exito";
    graph2.valueField = "Sin Exito";
    graph2.balloonText = "Sin Exito:[[value]] %";
    graph2.labelText = "[[value]] %";
    graph2.lineAlpha = 0;
    graph2.fillColors = "#81acd9";
    graph2.fillAlphas = 1;
    chart.addGraph(graph2);

    // tercer graph
    var graph3 = new AmCharts.AmGraph();
    graph3.type = "column";
    graph3.title = "No aceptaron Trans";
    graph3.valueField = "No aceptaron Trans";
    graph3.balloonText = "No aceptaron Trans:[[value]] %";
    graph3.labelText = "[[value]] %";
    graph3.lineAlpha = 0;
    graph3.fillColors = "#FF0000";
    graph3.fillAlphas = 1;
    chart.addGraph(graph3);

    // LEGEND
    var legend = new AmCharts.AmLegend();
    chart.addLegend(legend);

    //chart.creditsPosition = "top-right";

    // WRITE
    chart.write(div);
}


function creaGraficoColumnasComparacionTrato(data,div, rotation,tamano, escala_min, escala_max  ) {

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
    chart.addTitle("Trato hgjghj  ghfgh");
    chart.dataProvider = chartData;
    chart.categoryField = "respuesta";

    // this single line makes the chart a bar chart,
    // try to set it to false - your bars will turn to columns

// SERIAL CHART
    chart = new AmCharts.AmSerialChart();
    chart.dataProvider = chartData;
    chart.categoryField = "ola";
    chart.startDuration = 1;
    chart.plotAreaBorderColor = "#DADADA";
    chart.plotAreaBorderAlpha = 1;
    // this single line makes the chart a bar chart

    if(rotation ==true) {
        chart.rotate = true;
    } else {
        chart.rotate = false;
    }
    // AXES
    // Category
    var categoryAxis = chart.categoryAxis;
    categoryAxis.gridPosition = "start";
    categoryAxis.gridAlpha = 0.1;
    categoryAxis.axisAlpha = 0;

    // Value
    var valueAxis = new AmCharts.ValueAxis();
    valueAxis.axisAlpha = 0;
    valueAxis.gridAlpha = 0.1;
    if(escala_min != undefined) valueAxis.minimum = escala_min;

    if(escala_max != undefined) valueAxis.maximum = escala_max ;
    // valueAxis.position = "top";
    chart.addValueAxis(valueAxis);

    // GRAPHS
    // first graph
    var graph1 = new AmCharts.AmGraph();
    graph1.type = "column";
    graph1.title = "Debajo del Estandar";
    graph1.valueField = "Debajo del Estandar";
    graph1.balloonText = "Debajo del Estandar:[[value]] %";
    graph1.labelText = "[[value]] %";
    graph1.lineAlpha = 0;
    graph1.fillColors = "#009B3A";
    graph1.fillAlphas = 1;
    chart.addGraph(graph1);

    // second graph
    var graph2 = new AmCharts.AmGraph();
    graph2.type = "column";
    graph2.title = "Estandar";
    graph2.valueField = "Estandar";
    graph2.balloonText = "Estandar:[[value]] %";
    graph2.labelText = "[[value]] %";
    graph2.lineAlpha = 0;
    graph2.fillColors = "#81acd9";
    graph2.fillAlphas = 1;
    chart.addGraph(graph2);

    // tercer graph
    var graph3 = new AmCharts.AmGraph();
    graph3.type = "column";
    graph3.title = "Superior";
    graph3.valueField = "Superior";
    graph3.balloonText = "Superior:[[value]] %";
    graph3.labelText = "[[value]] %";
    graph3.lineAlpha = 0;
    graph3.fillColors = "#FF0000";
    graph3.fillAlphas = 1;
    chart.addGraph(graph3);

    // LEGEND
    var legend = new AmCharts.AmLegend();
    chart.addLegend(legend);

    //chart.creditsPosition = "top-right";

    // WRITE
    chart.write(div);
}


function creaGraficoColumnasComparacionSiNo(data,div, rotation,tamano,escala_min, escala_max  ) {

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

// SERIAL CHART
    chart = new AmCharts.AmSerialChart();
    chart.dataProvider = chartData;
    chart.categoryField = "ola";
    chart.startDuration = 1;
    chart.plotAreaBorderColor = "#DADADA";
    chart.plotAreaBorderAlpha = 1;
    // this single line makes the chart a bar chart

    if(rotation ==true) {
        chart.rotate = true;
    } else {
        chart.rotate = false;
    }
    // AXES
    // Category
    var categoryAxis = chart.categoryAxis;
    categoryAxis.gridPosition = "start";
    categoryAxis.gridAlpha = 0.1;
    categoryAxis.axisAlpha = 0;

    // Value
    var valueAxis = new AmCharts.ValueAxis();
    valueAxis.axisAlpha = 0;
    valueAxis.gridAlpha = 0.1;


    if(escala_min != undefined) valueAxis.minimum = escala_min;

    if(escala_max != undefined) valueAxis.maximum = escala_max ;
    // valueAxis.position = "top";
    // valueAxis.position = "top";
    chart.addValueAxis(valueAxis);

    // GRAPHS
    // first graph
    var graph1 = new AmCharts.AmGraph();
    graph1.type = "column";
    graph1.title = "Si";
    graph1.valueField = "Si";
    graph1.balloonText = "Si:[[value]] %";
    graph1.labelText = "[[value]] %";
    graph1.lineAlpha = 0;
    graph1.fillColors = "#009B3A";
    graph1.fillAlphas = 1;
    chart.addGraph(graph1);

    // second graph
    var graph2 = new AmCharts.AmGraph();
    graph2.type = "column";
    graph2.title = "No";
    graph2.valueField = "No";
    graph2.balloonText = "No:[[value]] %";
    graph2.labelText = "[[value]] %";
    graph2.lineAlpha = 0;
    graph2.fillColors = "#81acd9";
    graph2.fillAlphas = 1;
    chart.addGraph(graph2);

    // LEGEND
    var legend = new AmCharts.AmLegend();
    chart.addLegend(legend);

    //chart.creditsPosition = "top-right";

    // WRITE
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


function creaGraficoLinial(data,div){
    var chartData=data;
    var chart;
    // SERIAL CHART
    chart = new AmCharts.AmSerialChart();
    chart.dataProvider = chartData;
    chart.categoryField = "tiempo";
    chart.startDuration = 0.5;
    chart.balloon.color = "#000000";

    // AXES
    // category
    var categoryAxis = chart.categoryAxis;
    categoryAxis.fillAlpha = 1;
    categoryAxis.fillColor = "#FAFAFA";
    categoryAxis.gridAlpha = 0;
    categoryAxis.axisAlpha = 0;
    categoryAxis.gridPosition = "start";
    //categoryAxis.position = "top";

    // value
    var valueAxis = new AmCharts.ValueAxis();
    valueAxis.title = "Place taken";
    valueAxis.dashLength = 1;
    valueAxis.axisAlpha = 0;
   // valueAxis.minimum = 1;
  //  valueAxis.maximum = 6;
  //  valueAxis.integersOnly = true;
   // valueAxis.gridCount = 10;
   // valueAxis.reversed = true; // this line makes the value axis reversed
    chart.addValueAxis(valueAxis);

    // GRAPHS
    // Italy graph
    var graph = new AmCharts.AmGraph();
    graph.title = "ola 1";
    graph.valueField = "ola 1";
    graph.hidden = false; // this line makes the graph initially hidden
    graph.balloonText = "place taken by Italy in [[category]]: [[value]]";
    graph.lineAlpha = 1;
    graph.bullet = "round";
    chart.addGraph(graph);
    // Germany graph
    var graph = new AmCharts.AmGraph();
    graph.title = "ola 2";
    graph.valueField = "ola 2";
    graph.balloonText = "place taken by Germany in [[category]]: [[value]]";
    graph.bullet = "round";
    chart.addGraph(graph);
    // United Kingdom graph
    var graph = new AmCharts.AmGraph();
    graph.title = "ola 3";
    graph.valueField = "ola 3";
    graph.balloonText = "place taken by UK in [[category]]: [[value]]";
    graph.bullet = "round";
    chart.addGraph(graph);
    // CURSOR
    var chartCursor = new AmCharts.ChartCursor();
    chartCursor.cursorPosition = "mouse";
    chartCursor.zoomable = false;
    chartCursor.cursorAlpha = 0;
    chart.addChartCursor(chartCursor);
    // LEGEND
    var legend = new AmCharts.AmLegend();
    legend.useGraphSettings = true;
    chart.addLegend(legend);
    // WRITE
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
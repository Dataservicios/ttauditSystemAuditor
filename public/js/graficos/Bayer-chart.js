/**
 *
 * @param data
 * @param div
 */
var url_base =  "http://ttaudit.com" ;

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
                chart.innerRadius = "70%";
                chart.startDuration = 2;
                chart.labelRadius = 15;
                chart.balloonText = "[<span style='font-size:14px'>([[percents]]%)</span>";
                // the following two lines makes the chart 3D
               // chart.depth3D = 10;
                //chart.angle = 15;

            chart.write(div);

 	}


function createGraphPie(data,div){

    var chartData=data;
    var chart;
    chart = new AmCharts.AmPieChart();
        // PIE CHART
        chart = new AmCharts.AmPieChart();
        chart.colorField = "color";
        chart.dataProvider = chartData;
        chart.titleField = "tipo";
        chart.valueField = "cantidad";
        chart.labelText = "[[title]]: [[percents]]% ([[value]])";
       // chart.outlineColor = "#FFFFFF";
    chart.startEffect = "elastic";
    chart.percentPrecision=0;
    //chart.innerRadius = "70%";
    chart.startDuration = 2;
    chart.labelRadius = 15;
        chart.outlineAlpha = 0.8;
        chart.outlineThickness = 2;
   // chart.balloonText = "[<span style='font-size:14px'>([[percents]]%)</span>";

        // WRITE
        chart.write(div);

}

// Function creaGraficoColumnas
// PARAMETROS
//---------------------------------------
// data : tipo objeto json con propiedad respuesta.
// div: nombre de la capa o div en donde se mostrara el grafico por html
// rotation: Tipo Bool, muestra la orientación del lgráfico, horizontal o vertical
// tamano : Tipo entero. Extrae un tamaño determinado de caracteres que luego mostrará en el eje X

/**
 *
 * @param data
 * @param div
 * @param rotation
 * @param tamano
 * @param escala_min
 * @param escala_max
 */
function creaGraficoColumnas(data,div, rotation,tamano, escala_min, escala_max,colorBar ) {

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
    chart.pathToImages = url_base + "/lib/amcharts/images/";
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

    // SCROLLBAR
    var chartScrollbar = new AmCharts.ChartScrollbar();
    chart.addChartScrollbar(chartScrollbar);

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
    valueAxis.axisColor = "#1A8EC7";
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
   //graph.valueField = "cantidad";
    graph.valueField = "porcentaje";
    graph.fontSize = 9;
    graph.type = "column";
    graph.scrollbar
    graph.labelPosition = "middle";
    graph.labelText = "[[porcentaje]]% ([[cantidad]])";
    graph.balloonText = "[[category]]: [[porcentaje]] % ([[cantidad]])";
    graph.lineAlpha = 0;
    graph.labelColorField="color";

    if(colorBar== undefined ||  colorBar == null   ) {
        graph.fillColors = "#1A8EC7";
    } else {
        graph.fillColors = colorBar;
    }

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
 function creaGraficoColumnasStaked(data,div, rotation,tamano,escala_min, escala_max  ) {



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
             // SERIALL CHART
             chart = new AmCharts.AmSerialChart();
             chart.dataProvider = chartData;
             chart.categoryField = "category";
             chart.plotAreaBorderAlpha = 0.2;
             chart.rotate = rotation;

             // AXES
             // Category
             var categoryAxis = chart.categoryAxis;
             categoryAxis.gridAlpha = 0.1;
             categoryAxis.axisAlpha = 0;
             categoryAxis.gridPosition = "start";

             // value
             var valueAxis = new AmCharts.ValueAxis();
             valueAxis.stackType = "regular";
             valueAxis.gridAlpha = 0.1;
             valueAxis.axisAlpha = 0;

             if(escala_min != undefined) valueAxis.minimum = escala_min;
             if(escala_max != undefined) valueAxis.maximum = escala_max ;
             chart.addValueAxis(valueAxis);

             // GRAPHS
             // firstgraph
             var graph = new AmCharts.AmGraph();
             graph.title = "Si Recomienda";
             graph.labelText = "[[value]] % ([[cant_si]])";
             graph.valueField = "Si";
             graph.fontSize = 9;
             graph.type = "column";
             graph.lineAlpha = 0;
             graph.fillAlphas = 1;
             graph.lineColor = "#1A8EC7";
             graph.balloonText = "<b><span style='color:#1A8EC7; font-size:14px'>[[title]]</b></span><br><span style='font-size:9px'>[[category]]: <b>[[value]] %</b></span>";
             graph.labelPosition = "middle";
             graph.labelColorField="color";
             chart.addGraph(graph);

             // second graph
             graph = new AmCharts.AmGraph();
             graph.title = "No Recomienda";
             graph.labelText = "[[value]] % ([[cant_no]])";
             graph.valueField = "No";
             graph.fontSize = 9;
             graph.type = "column";
             graph.lineAlpha = 0;
             graph.fillAlphas = 1;
             graph.lineColor = "#cbcbcb";
             graph.balloonText = "<b><span style='color:#cbcbcb;font-size:14px'>[[title]]</b></span><br><span style='font-size:9px'>[[category]]: <b>[[value]] %</b></span>";
             graph.labelPosition = "middle";
             chart.addGraph(graph);


             // LEGEND
             var legend = new AmCharts.AmLegend();
             legend.position = "bottom";
             legend.borderAlpha = 0.3;
             legend.horizontalGap = 10;
             legend.switchType = "v";
             chart.addLegend(legend);

             chart.creditsPosition = "top-right";

             // WRITE
             chart.write(div);
    }



/**
 *
 * @param data
 * @param div
 */
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

    //console.log(chartData[0].length);
    $.each(chartData[0], function(indice, nombre){
        //console.log(' >', indice + '.' + nombre);
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
    graph.fontSize = 9;
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
    graph.fontSize = 9;
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
//creaGraficoColumnasPorcentajesDinamic(chartData2,"chartdivPrio534154",false,false,undefined,undefined,45)
/**
 *
 * @param data
 * @param div
 * @param activelegend
 * @param rotation
 * @param escala_min
 * @param escala_max            Escala máxima y del eje
 * @param label_rotation_grade  Determina el angulo de rotación de las etiquetas del eje X
 */
function creaGraficoColumnasPorcentajesDinamic(data,div, activelegend , rotation,escala_min, escala_max,label_rotation_grade) {

    var chartData=data;
    var chart;
    // SERIAL CHART
    // title of the chart
    chart = new AmCharts.AmSerialChart();
    chart.pathToImages = url_base + "/lib/amcharts/images/";
    chart.dataProvider = chartData;
    chart.categoryField = "tipo";
    chart.plotAreaBorderAlpha = 0.2;
    if(rotation ==true) {
        chart.rotate = true;
    }
    var chartScrollbar = new AmCharts.ChartScrollbar();
    chart.addChartScrollbar(chartScrollbar);
    //
    //console.log(chartData[0].length);

//AXES
    // category
    var categoryAxis = chart.categoryAxis;
    categoryAxis.gridAlpha = 0.1;
    categoryAxis.axisAlpha = 0;label_rotation_grade=45;

    if(label_rotation_grade != undefined) categoryAxis.labelRotation = label_rotation_grade;

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

    if(escala_min != undefined) valueAxis.minimum = escala_min;
    if(escala_max != undefined) valueAxis.maximum = escala_max ;

    valueAxis.gridAlpha = 0.1;
    chart.percentPrecision=0;
    chart.addValueAxis(valueAxis);



    var graph;
    var i=0;
    var colores = ["#1a8ec7","#84cff4","#b5e4fb", "#ddf2fb", "#d6f1fd", "#69A55C", "#B5B8D3", "#F4E23B"];
    //console.log(colores);
    $.each(chartData[0], function(indice, valor){
        i++;
        if (i > 1) {
            //console.log(' >', indice + '.' + valor);
            graph= new AmCharts.AmGraph();
            graph.title = indice;
            graph.labelText = "[[value]] ([[percents]]%)";
            graph.valueField = indice;
            graph.type = "column";
            graph.fontSize = 9;
            graph.lineAlpha = 0;
            graph.fillAlphas = 1;
            graph.lineColor = colores[i-2];
           // graph.balloonText = "<span style='font-size:12px; color:#555555;'><b>[[category]]</b></span><br><span style='font-size:11px'>[[title]]:<b>[[value]]</b></span>";
            graph.balloonText = "<span style='font-size:12px; color:#555555;'><b>[[category]]</b></span><br><span style='font-size:11px'>[[title]]</span><br><span style='font-size:11px'><b>[[value]] ([[percents]]%)</b></span>";
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
/**
 *
 * @param data
 * @param tamano
 * @returns {*}
 */
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
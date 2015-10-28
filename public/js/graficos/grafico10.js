 	
$(function() {
		var jqxhr = $.getJSON('../../data/data2.php?grafico=10');


        //INGRESO DNI
		jqxhr.done(function (data) {
			//console.log(data);
			creaGraficoColumnas(data,"chartdiv2");
			//creaGraficoLineal(data,"chartdiv2");
			//crearGraficoPastel(data,"chartdiv3");

		});


		function creaGraficoColumnas(data,div) {
		var chartData=data;
		  	var chart;
		  	// SERIAL CHART
		  	// title of the chart
		  		chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.categoryField = "agente";
                // this single line makes the chart a bar chart,
                // try to set it to false - your bars will turn to columns
                chart.rotate = true;
                // the following two lines makes chart 3D
                // chart.depth3D = 20;
                // chart.angle = 30;

                // AXES
                // Category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.gridPosition = "start";
                categoryAxis.axisColor = "#DADADA";
                categoryAxis.fillAlpha = 1;
                categoryAxis.gridAlpha = 0;
                categoryAxis.fillColor = "#FAFAFA";

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
                graph.balloonText = "[[category]]:[[value]]";
                graph.lineAlpha = 0;
                graph.fillColors = "#009B3A";
                graph.fillAlphas = 1;
                chart.addGraph(graph);

                chart.creditsPosition = "top-right";

            chart.write(div);

 	}
});
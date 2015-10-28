 	
$(function() {
		var jqxhr = $.getJSON('../../data/data1.php?grafico=1');


        //INGRESO DNI
		jqxhr.done(function (data) {
			//console.log(data);
			creaGraficoDonut(data,"chartdiv1");
			//creaGraficoLineal(data,"chartdiv2");
			//crearGraficoPastel(data,"chartdiv3");

		});


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
});
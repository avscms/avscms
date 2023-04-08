/* Webarch Admin Dashboard 
/* This JS is Only DEMO Purposes 
-----------------------------------------------------------------*/	
$(document).ready(function() {		

	var d2 = [ [1, 30],
            [2, 20],
            [3, 10],
            [4, 30],
            [5,15],
            [6, 25],
            [7, 40]

];
	var d1 = [
            [1, 30],
            [2, 30],
            [3, 20],
            [4, 40],
            [5, 30],
            [6, 45],
            [7, 50],
];
	var plot = $.plotAnimator($("#placeholder"), [
			{  	label: "Label 1",
				data: d2, 	
				lines: {				
					fill: 0.6,
					lineWidth: 0,				
				},
				color:['#f89f9f']
			},{ 
				data: d1, 
				animator: {steps: 60, duration: 1000, start:0}, 		
				lines: {lineWidth:2},	
				shadowSize:0,
				color: '#f35958'
			},{
				data: d1, 
				points: { show: true, fill: true, radius:6,fillColor:"#f35958",lineWidth:3 },	
				color: '#fff',				
				shadowSize:0
			},
			{	label: "Label 2",
				data: d2, 
				points: { show: true, fill: true, radius:6,fillColor:"#f5a6a6",lineWidth:3 },	
				color: '#fff',				
				shadowSize:0
			}
		],{	xaxis: {
		tickLength: 0,
		tickDecimals: 0,
		min:2,

				font :{
					lineHeight: 13,
					style: "normal",
					weight: "bold",
					family: "sans-serif",
					variant: "small-caps",
					color: "#6F7B8A"
				}
			},
			yaxis: {
				ticks: 3,
                tickDecimals: 0,
				tickColor: "#f0f0f0",
				font :{
					lineHeight: 13,
					style: "normal",
					weight: "bold",
					family: "sans-serif",
					variant: "small-caps",
					color: "#6F7B8A"
				}
			},
			grid: {
				backgroundColor: { colors: [ "#fff", "#fff" ] },
				borderWidth:1,borderColor:"#f0f0f0",
				margin:0,
				minBorderMargin:0,							
				labelMargin:20,
				hoverable: true,
				clickable: true,
				mouseActiveRadius:6
			},
			legend: { show: false}
		});


	$("#placeholder").bind("plothover", function (event, pos, item) {
				if (item) {
					var x = item.datapoint[0].toFixed(2),
						y = item.datapoint[1].toFixed(2);

					$("#tooltip").html(item.series.label + " of " + x + " = " + y)
						.css({top: item.pageY+5, left: item.pageX+5})
						.fadeIn(200);
				} else {
					$("#tooltip").hide();
				}
	
		});
	
	$("<div id='tooltip'></div>").css({
			position: "absolute",
			display: "none",
			border: "1px solid #fdd",
			padding: "2px",
			"background-color": "#fee",
			"z-index":"99999",
			opacity: 0.80
	}).appendTo("body");
	$("#mini-chart-orders").sparkline([1,4,6,2,0,5,6,4], {
		type: 'bar',
		height: '30px',
		barWidth: 6,
		barSpacing: 2,
		barColor: '#f35958',
		negBarColor: '#f35958'});

	$("#mini-chart-other").sparkline([1,4,6,2,0,5,6,4], {
		type: 'bar',
		height: '30px',
		barWidth: 6,
		barSpacing: 2,
		barColor: '#0aa699',
		negBarColor: '#0aa699'});	
	
	$('#ram-usage').easyPieChart({
		lineWidth:9,
		barColor:'#f35958',
		trackColor:'#e5e9ec',
		scaleColor:false
    });
	$('#disk-usage').easyPieChart({
		lineWidth:9,
		barColor:'#7dc6ec',
		trackColor:'#e5e9ec',
		scaleColor:false
    });
	
	// Moris Charts - Line Charts
	
	Morris.Line({
	  element: 'line-example',
	  data: [
		{ y: '2006', a: 50, b: 40 },
		{ y: '2007', a: 65,  b: 55 },
		{ y: '2008', a: 50,  b: 40 },
		{ y: '2009', a: 75,  b: 65 },
		{ y: '2010', a: 50,  b: 40 },
		{ y: '2011', a: 75,  b: 65 },
		{ y: '2012', a: 100, b: 90 }
	  ],
	  xkey: 'y',
	  ykeys: ['a', 'b'],
	  labels: ['Series A', 'Series B'],
	  lineColors:['#0aa699','#d1dade'],
	});
	
	Morris.Area({
	  element: 'area-example',
	  data: [
		{ y: '2006', a: 100, b: 90 },
		{ y: '2007', a: 75,  b: 65 },
		{ y: '2008', a: 50,  b: 40 },
		{ y: '2009', a: 75,  b: 65 },
		{ y: '2010', a: 50,  b: 40 },
		{ y: '2011', a: 75,  b: 65 },
		{ y: '2012', a: 100, b: 90 }
	  ],
	  xkey: 'y',
	  ykeys: ['a', 'b'],
	  labels: ['Series A', 'Series B'],
	  lineColors:['#0090d9','#b7c1c5'],
	  lineWidth:'0',
	   grid:'false',
	  fillOpacity:'0.5'
	});
	
	Morris.Donut({
	  element: 'donut-example',
	  data: [
		{label: "Download Sales", value: 12},
		{label: "In-Store Sales", value: 30},
		{label: "Mail-Order Sales", value: 20}
	  ],
	  colors:['#60bfb6','#91cdec','#eceff1']
	});

	$('#mysparkline').sparkline([4,3,3,1,4,3,2,2,3], {
			type: 'line', 
			width: '100%',
			height:'250px',
			fillColor: 'rgba(209, 218, 222, 0.30)',
			lineColor: '#fff',
			spotRadius: 4,
			valueSpots:[4,3,3,1,4,3,2,2,3],
			minSpotColor: '#d1dade',
			maxSpotColor: '#d1dade',
			highlightSpotColor: '#d1dade',
			 highlightLineColor: '#bec6ca',
			normalRangeMin: 0
	});
	$('#mysparkline').sparkline([3,2,3,4,3,2,4,1,3], {
					type: 'line', 
					composite: true,
					width: '100%',
					fillColor: ' rgba(0, 141, 214, 0.10)',
					lineColor: '#fff',
					minSpotColor: '#167db2',
					maxSpotColor: '#167db2',
					highlightSpotColor: '#8fcded',
					 highlightLineColor: '#bec6ca',
					spotRadius: 4,
					valueSpots:[3,2,3,4,3,2,4,1,3],
					normalRangeMin: 0
	});	
	
	$("#spark-2").sparkline([4,3,3,4,5,4,3,2,4,5,6,4,3,5,2,4,6], {
		type: 'line',
		width: '100%',
		height: '200',
		lineColor: '#0aa699',
		fillColor: '#e6f6f5',
		minSpotColor: '#0c948a',
		maxSpotColor: '#78cec7',
		highlightSpotColor: '#78cec7',
		highlightLineColor: '#78cec7',
		spotRadius: 5
	});
	
	$("#sparkline-pie").sparkline([8,2,3], {
		type: 'pie',
		width: '100%',
		height: '100%',
		sliceColors: ['#eceff1','#f35958','#dee1e3'],
		offset: 10,
		borderWidth: 0,
		borderColor: '#000000 '
	});
	
	var seriesData = [ [], []];
	var random = new Rickshaw.Fixtures.RandomData(50);

	for (var i = 0; i < 50; i++) {
		random.addData(seriesData);
	}

	graph = new Rickshaw.Graph( {
		element: document.querySelector("#updatingChart"),
		height: 200,
		renderer: 'area',
		series: [
			{
				data: seriesData[0],
				color: 'rgba(0,144,217,0.51)',
				name:'DB Server'
			},{
				data: seriesData[1],
				color: '#eceff1',
				name:'Web Server'
			}
		]
	} );
	var hoverDetail = new Rickshaw.Graph.HoverDetail( {
		graph: graph
	});

	setInterval( function() {
		random.removeData(seriesData);
		random.addData(seriesData);
		graph.update();

	},1000);
	
	//Bar Chart  - Jquert flot
	
    var d1_1 = [
        [1325376000000, 120],
        [1328054400000, 70],
        [1330560000000, 100],
        [1333238400000, 60],
        [1335830400000, 35]
    ];
 
    var d1_2 = [
        [1325376000000, 80],
        [1328054400000, 60],
        [1330560000000, 30],
        [1333238400000, 35],
        [1335830400000, 30]
    ];
 
    var d1_3 = [
        [1325376000000, 80],
        [1328054400000, 40],
        [1330560000000, 30],
        [1333238400000, 20],
        [1335830400000, 10]
    ];
 
    var d1_4 = [
        [1325376000000, 15],
        [1328054400000, 10],
        [1330560000000, 15],
        [1333238400000, 20],
        [1335830400000, 15]
    ];
 
    var data1 = [
        {
            label: "Product 1",
            data: d1_1,
            bars: {
                show: true,
                barWidth: 12*24*60*60*300,
                fill: true,
                lineWidth:0,
                order: 1,
                fillColor:  "rgba(243, 89, 88, 0.7)"
            },
            color: "rgba(243, 89, 88, 0.7)"
        },
        {
            label: "Product 2",
            data: d1_2,
            bars: {
                show: true,
                barWidth: 12*24*60*60*300,
                fill: true,
                lineWidth: 0,
                order: 2,
                fillColor:  "rgba(251, 176, 94, 0.7)"
            },
            color: "rgba(251, 176, 94, 0.7)"
        },
        {
            label: "Product 3",
            data: d1_3,
            bars: {
                show: true,
                barWidth: 12*24*60*60*300,
                fill: true,
                lineWidth: 0,
                order: 3,
                fillColor:  "rgba(10, 166, 153, 0.7)"
            },
            color: "rgba(10, 166, 153, 0.7)"
        },
        {
            label: "Product 4",
            data: d1_4,
            bars: {
                    show: true,
                barWidth: 12*24*60*60*300,
                fill: true,
                lineWidth: 0,
                order: 4,
                fillColor:  "rgba(0, 144, 217, 0.7)"
            },
            color: "rgba(0, 144, 217, 0.7)"
        },

    ];
 
    $.plot($("#placeholder-bar-chart"), data1, {
        xaxis: {
            min: (new Date(2011, 11, 15)).getTime(),
            max: (new Date(2012, 04, 18)).getTime(),
            mode: "time",
            timeformat: "%b",
            tickSize: [1, "month"],
            monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            tickLength: 0, // hide gridlines
            axisLabel: 'Month',
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
            axisLabelPadding: 5,
        },
        yaxis: {
            axisLabel: 'Value',
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
            axisLabelPadding: 5
        },
        grid: {
            hoverable: true,
            clickable: false,
            borderWidth: 1,
			borderColor:'#f0f0f0',
			labelMargin:8,
        },
        series: {
            shadowSize: 1
        }
    });
 
 
    function getMonthName(newTimestamp) {
        var d = new Date(newTimestamp);
 
        var numericMonth = d.getMonth();
        var monthArray = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
 
        var alphaMonth = monthArray[numericMonth];
 
        return alphaMonth;
    }
 

	 // ORDERED & STACKED CHART
    var data2 = [
        {
            label: "Product 1",
            data: d1_1,
            bars: {
                show: true,
                barWidth: 12*24*60*60*300*2,
                fill: true,
                lineWidth:0,
                order: 0,
                fillColor:  "rgba(243, 89, 88, 0.7)"
            },
            color: "rgba(243, 89, 88, 0.7)"
        },
        {
            label: "Product 2",
            data: d1_2,
            bars: {
                show: true,
                barWidth: 12*24*60*60*300*2,
                fill: true,
                lineWidth: 0,
                order: 0,
                fillColor:  "rgba(251, 176, 94, 0.7)"
            },
            color: "rgba(251, 176, 94, 0.7)"
        },
        {
            label: "Product 3",
            data: d1_3,
            bars: {
                show: true,
                barWidth: 12*24*60*60*300*2,
                fill: true,
                lineWidth: 0,
                order: 0,
                fillColor:  "rgba(10, 166, 153, 0.7)"
            },
            color: "rgba(10, 166, 153, 0.7)"
        },
        {
            label: "Product 4",
            data: d1_4,
            bars: {
                    show: true,
                barWidth: 12*24*60*60*300*2,
                fill: true,
                lineWidth: 0,
                order: 0,
                fillColor:  "rgba(0, 144, 217, 0.7)"
            },
            color: "rgba(0, 144, 217, 0.7)"
        },

    ];
	$.plot($('#stacked-ordered-chart'), data2, {		
		 grid: {
            hoverable: true,
            clickable: false,
            borderWidth: 1,
			borderColor:'#f0f0f0',
			labelMargin:8

        },
		        xaxis: {
            min: (new Date(2011, 11, 15)).getTime(),
            max: (new Date(2012, 04, 18)).getTime(),
            mode: "time",
            timeformat: "%b",
            tickSize: [1, "month"],
            monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            tickLength: 0, // hide gridlines
            axisLabel: 'Month',
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
            axisLabelPadding: 5
        },
				stack: true
	});
	// DATA DEFINITION
	function getData() {
		var data = [];

		data.push({
			data: [[0, 1], [1, 4], [2, 2]]
		});

		data.push({
			data: [[0, 5], [1, 3], [2, 1]]
		});

		return data;
	}
	
	
});
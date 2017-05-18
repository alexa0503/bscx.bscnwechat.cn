$(function	()	{



	$("<div id='tooltip'></div>").css({
		position: "absolute",
		display: "none",
		border: "1px solid #222",
		padding: "4px",
		color: "#fff",
		"border-radius": "4px",
		"background-color": "rgb(0,0,0)",
		opacity: 0.90
	}).appendTo("body");

	$("#placeholder").bind("plothover", function (event, pos, item) {

		var str = "(" + pos.x.toFixed(2) + ", " + pos.y.toFixed(2) + ")";
		$("#hoverdata").text(str);

		if (item) {
			var x = item.datapoint[0],
				y = item.datapoint[1];

				$("#tooltip").html("Total Sales : " + y)
				.css({top: item.pageY+5, left: item.pageX+5})
				.fadeIn(200);
		} else {
			$("#tooltip").hide();
		}
	});


	//Morris Chart (Total Visits)
	var totalVisitChart = Morris.Bar({
	  element: 'totalSalesChart',
	  data: [
	    { y: '2008', a: 100, b: 90 },
	    { y: '2009', a: 75,  b: 65 },
	    { y: '2010', a: 50,  b: 40 },
	    { y: '2011', a: 75,  b: 65 },
	    { y: '2012', a: 50,  b: 40 },
	    { y: '2013', a: 75,  b: 65 },
	    { y: '2014', a: 100, b: 90 }
	  ],
	  xkey: 'y',
	  ykeys: ['a', 'b'],
	  labels: ['Total Visits', 'Bounce Rate'],
	  barColors: ['#999', '#eee'],
	  grid: false,
	  gridTextColor: '#777',
	});
	






	
	$(window).resize(function(e)	{
		// Redraw All Chart
		setTimeout(function() {
			totalVisitChart.redraw();
			//plotWithOptions();
		},500);
	});

	$('#sidebarToggleLG').click(function()	{
		// Redraw All Chart
		setTimeout(function() {
			totalVisitChart.redraw();
			//plotWithOptions();
		},500);
	});

	$('#sidebarToggleSM').click(function()	{
		// Redraw All Chart
		setTimeout(function() {
			totalVisitChart.redraw();
			//plotWithOptions();
		},500);
	});
});

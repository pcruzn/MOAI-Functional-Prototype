<?php
include ("moai_db_connection.php");
include ("models/encounterService.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="flat-ui.css" />
	<title>Serie de tiempo para encuentros por fecha</title>
	<script src="Chart.js/Chart.js"></script>
</head>
<body>

<h3>Serie de tiempo para encuentros por fecha</h3>
<p>&nbsp;</p>
<div style="width: 50%" align="center">
		<canvas id="canvas" height="250" width="400">
  </canvas>
</div>

	<?php 
	
	$encounterDates = array();
	$encounterDatesCount = array();
	
	// after getting the associative array 'encounterType' -> 'encounterTypeCount'
	// (returned by getEncounterTypesCount()) we split the array
	// in separate key and value arrays.
	// this is done to ease the use of json_encode to put data for plots
	foreach (EncounterService::getEncounterDatesCount() as $arrayKey => $arrayValue) {
		$encounterDates[] = $arrayKey;
		$encounterDatesCount[] = $arrayValue;
	}
	
	?>

	<script>
			var lineChartData = {
			labels : <?php echo json_encode($encounterDates); ?>,
			datasets : [
				{
					label: "My Second dataset",
					fillColor : "rgba(151,187,205,0.2)",
					strokeColor : "rgba(151,187,205,1)",
					pointColor : "rgba(151,187,205,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(151,187,205,1)",
					data : <?php echo json_encode($encounterDatesCount); ?>
				}
			]
		}
	window.onload = function(){
		var ctx = document.getElementById("canvas").getContext("2d");
		window.myLine = new Chart(ctx).Line(lineChartData, {
			responsive: true
		});
	}
	</script>
    <footer>
  <p align="right"><a href="moai.php">Volver al inicio</a> <a href="index.php">Salir</a></p>
</footer>
	</body>
</html>
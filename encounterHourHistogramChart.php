<?php
include ("moai_db_connection.php");
include ("models/encounterService.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="flat-ui.css" />
	<title>Histograma por hora</title>
	<script src="Chart.js/Chart.js"></script>
</head>
<body>

<h3> Histograma para hora de encuentros</h3>
<p>&nbsp;</p>
<div style="width: 50%" align="center">
		<canvas id="canvas" height="450" width="600">
  </canvas>
</div>

	<?php 
	
	$encounterHours = array();
	$encounterHoursCount = array();
	
	// after getting the associative array 'encounterType' -> 'encounterTypeCount'
	// (returned by getEncounterTypesCount()) we split the array
	// in separate key and value arrays.
	// this is done to ease the use of json_encode to put data for plots
	foreach (EncounterService::getEncounterHoursCount() as $arrayKey => $arrayValue) {
		$encounterHours[] = $arrayKey;
		$encounterHoursCount[] = $arrayValue;
	}
	
	?>

	<script>

	var barChartData = {
		labels : <?php echo json_encode($encounterHours); ?>,
		datasets : [
			{
				fillColor : "rgba(220,220,220,0.9)",
				strokeColor : "rgba(220,220,220,0.8)",
				highlightFill: "rgba(220,220,220,0.75)",
				highlightStroke: "rgba(220,220,220,1)",
				data : <?php echo json_encode($encounterHoursCount); ?>
			}
		]
	}
	window.onload = function(){
		var ctx = document.getElementById("canvas").getContext("2d");
		window.myBar = new Chart(ctx).Bar(barChartData, {
			responsive : true
		});
	}
	</script>
    <footer>
  <p align="right"><a href="moai.php">Volver al inicio</a> <a href="index.php">Salir</a></p>
</footer>
	</body>
</html>
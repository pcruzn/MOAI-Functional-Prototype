<?php
include ("moai_db_connection.php");
include ("models/encounterService.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="flat-ui.css" />
	<title>Radar -Microlocalización administrativa de encuentros</title>
	<script src="Chart.js/Chart.js"></script>
</head>
<body>

<h3>Radar - Microlocalización  de encuentros</h3>
<p>&nbsp;</p>
<div style="width: 50%" align="center">
  <canvas id="canvas" height="250" width="400">
  </canvas>
</div>

	<?php 
	
	$encounterLocalization = array();
	$encounterLocalizationCount = array();
	
	// after getting the associative array 'encounterType' -> 'encounterTypeCount'
	// (returned by getEncounterTypesCount()) we split the array
	// in separate key and value arrays.
	// this is done to ease the use of json_encode to put data for plots
	foreach (EncounterService::getEncounterMicroLocalizationCount() as $arrayKey => $arrayValue) {
		$encounterLocalization[] = $arrayKey;
		$encounterLocalizationCount[] = $arrayValue;
	}
	
	?>
    
	<script>
		
		<?php 
		
			if ($_GET['action'] == 2) {
				?>
				
				var radarChartData = {
		// labels data points are converted using json_encode to meet
		// Chart.js input requirements (see below)
		labels: ['a', 'b']; ?>,
		datasets: [
			{
				label: "My Second dataset",
				fillColor: "rgba(151,187,205,0.2)",
				strokeColor: "rgba(151,187,205,1)",
				pointColor: "rgba(151,187,205,1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(151,187,205,1)",
				data: [1, 2]; ?>
			}
		]
		};
				
				<?php
			}
		
		?>
		
		
		var radarChartData = {
		// labels data points are converted using json_encode to meet
		// Chart.js input requirements (see below)
		labels: <?php echo json_encode($encounterLocalization); ?>,
		datasets: [
			{
				label: "My Second dataset",
				fillColor: "rgba(151,187,205,0.2)",
				strokeColor: "rgba(151,187,205,1)",
				pointColor: "rgba(151,187,205,1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(151,187,205,1)",
				data: <?php echo json_encode($encounterLocalizationCount); ?>
			}
		]
		};
		window.onload = function(){
			window.myRadar = new Chart(document.getElementById("canvas").getContext("2d")).Radar(radarChartData, {
			responsive: true
		});
		}
		
	</script>
    
    <footer>
  <p align="right"><a href="moai.php">Volver al inicio</a> <a href="index.php">Salir</a></p>
</footer>
	</body>
</html>
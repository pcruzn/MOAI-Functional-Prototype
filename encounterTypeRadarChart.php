<?php
include ("moai_db_connection.php");
include ("models/encounterService.php");
include ("header.php");
?>

	<h3>Radar - Tipo de Encuentros</h3>
	<div class="btn-group" data-toggle="buttons-checkbox">
		<button class="btn btn-small btn-primary" href="#myModal" data-toggle="modal" onclick="loadForm()">Crear agrupación</button>
		<button onclick="resetGroup()" class="btn btn-small btn-primary">Reset agrupación</button>

	</div>
	<!-- Button to trigger modal -->


	<!-- Modal -->
	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h6 id="myModalLabel">Crear Agrupación</h6>
		</div>
		<div class="modal-body">
			<div id="groupError"></div>
			<form id="groupForm" class="form-horizontal">
				<div class="control-group"></div>
				<input id="groupName" type="text" placeholder="Nombre Agrupación" class="span3 small"/>
			</form>

		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
			<button class="btn btn-primary" id="createBotton" onclick="createGroup()">Crear</button>
		</div>
	</div>

	<div style="width: 50%" align="center" id="idCanvas">
		<canvas id="canvas" height="250" width="400">
		</canvas>
	</div>

<?php

$encounterTypes = array();
$encounterTypesCount = array();

// after getting the associative array 'encounterType' -> 'encounterTypeCount'
// (returned by getEncounterTypesCount()) we split the array
// in separate key and value arrays.
// this is done to ease the use of json_encode to put data for plots
foreach (EncounterService::getEncounterTypesCount() as $arrayKey => $arrayValue) {
	$encounterTypes[] = $arrayKey;
	$encounterTypesCount[] = $arrayValue;
}

?>

	<script>
		String.format = function() {
			// The string containing the format items (e.g. "{0}")
			// will and always has to be the first argument.
			var theString = arguments[0];

			// start with the second argument (i = 1)
			for (var i = 1; i < arguments.length; i++) {
				// "gm" = RegEx options for Global search (more than one instance)
				// and for Multiline search
				var regEx = new RegExp("\\{" + (i - 1) + "\\}", "gm");
				theString = theString.replace(regEx, arguments[i]);
			}

			return theString;
		}


		var encounterTypes = <?php echo json_encode($encounterTypes); ?>;
		var encounterTypesCount = <?php echo json_encode($encounterTypesCount); ?>;
		var _encounterTypes = encounterTypes;
		var _encounterTypesCount = encounterTypesCount;

		function loadForm() {
			var zip =[];
			$("#groupForm div.control-group").html("")
			for (var i = 0; i < encounterTypes.length; i++) {
				zip.push([encounterTypes[i], encounterTypesCount[i]]);
				var checkboxHtml = String.format('<label class="checkbox" for="checkbox1"> <input type="checkbox" value="{1}" id="checkbox{0}" data-count="{2}" data-toggle="checkbox"> {1}</label>',
					i+1, encounterTypes[i], encounterTypesCount[i]);
				$("#groupForm div.control-group").append(checkboxHtml);
			}
			$('[data-toggle="checkbox"]').each(function () {
				var $checkbox = $(this);
				$checkbox.checkbox();
			});
		}

		function resetGroup() {
			encounterTypes = _encounterTypes;
			encounterTypesCount = _encounterTypesCount;
			resetCanvas();
			createChar();
		}

		function createGroup() {
			var encounterTypes_ = []
			var encounterTypesCount_ = []
			var groupCount = 0;
			$("#groupForm div.control-group input").each( function() {
				if (!$(this).is(':checked')){
					encounterTypes_.push($(this).val());
					encounterTypesCount_.push($(this).attr("data-count"));
				}else{
					groupCount += parseInt($(this).attr("data-count"));
				}
			});
			var groupName = $("#groupName").val();
			if(groupCount>0 && groupName != ""){
				encounterTypes_.push(groupName);
				encounterTypesCount_.push(groupCount);
				$("#groupName").val("");
				encounterTypes = encounterTypes_;
				encounterTypesCount = encounterTypesCount_;
				resetCanvas();
				createChar();
				$('#myModal').modal('toggle');
			}else{
				$("#groupError").append('<div class="alert alert-error moai-alert"><button type="button" class="close" data-dismiss="alert">&times;</button> No ingresado nombre o selección. </div>');
			}

		}

		$( document ).ready(function() {

			createChar();
		});

		var resetCanvas = function () {
			$('#canvas').remove(); // this is my <canvas> element
			$('#idCanvas').append('<canvas id="canvas" height="250" width="400"><canvas>');
		};

		function createChar() {
			var radarChartData = {
				// labels data points are converted using json_encode to meet
				// Chart.js input requirements (see below)
				labels: encounterTypes,
				datasets: [
					{
						label: "My Second dataset",
						fillColor: "rgba(151,187,205,0.2)",
						strokeColor: "rgba(151,187,205,1)",
						pointColor: "rgba(151,187,205,1)",
						pointStrokeColor: "#fff",
						pointHighlightFill: "#fff",
						pointHighlightStroke: "rgba(151,187,205,1)",
						data: encounterTypesCount
					}
				]
			};
			window.myRadar = new Chart(document.getElementById("canvas").getContext("2d")).Radar(radarChartData, {
				responsive: true
			});
		}

	</script>

<?php
include ("footer.html");
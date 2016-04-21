<?php
include ("moai_db_connection.php");
include ("models/encounterService.php");
include ("models/scrapingService.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="flat-ui.css" />
<title>MOAI</title>
</head>


<body>
<h3>Ingreso de Encuentro</h3>
<p>Usted está pronto a registrar un encuentro temporalmente almacenado (i.e., proveniente de algún proceso de 'web-scraping' anterior) a la base de datos. </p>

<?php

echo $_GET['action'];


if ($_GET['action'] == 1) {
	
	// CAUTION: for now, has scraper is always 0!
	if (EncounterService::storeEncounter($_POST['slctSource'], $_POST['txtDescription'], $_POST['txtDate'], $_POST['slctHour'], $_POST['slctDuration'], $_POST['slctLocalization'], $_POST['slctMicrolocalization'], $_POST['slctEncounterType']) == 1) {
		
		
	}
		
}


foreach (ScrapingService::getSourcesAndId() as $arrayKey => $arrayValue) {
				$optionId[] = $arrayKey;
				$optionValue[] = $arrayValue;
			}
	
			$optionIndex = 0;			
			while (!is_null($optionId[$optionIndex])) {
				echo "$optionId[$optionIndex] $optionValue[$optionIndex] <br>";
				$optionIndex++;
			}

?>

<?php
	
$temporaryEncounterDataDescriptor = EncounterService::getTemporaryEncounterById($_GET['id']);
$temporaryEncounterData = mysql_fetch_array($temporaryEncounterDataDescriptor, MYSQL_NUM);

?>

<form id="form1" name="form1" method="post" action="encounterAdd.php?action=1&sourceId=<?php echo $_GET['id']; ?>">
  <p>&nbsp;</p>
  <table border="0" align="center">
    <tr>
      <td><p>&nbsp;</p>
        <table width="481" border="1" align="center">
          <tr>
            <td width="144">Descripción:</td>
            <td width="327" align="center"><label for="txtDescription"></label>
            <input name="txtDescription" type="text" id="txtSourceName" value="<?php echo $temporaryEncounterData[0]; ?>" size="50" maxlength="300" /></td>
          </tr>
          <tr>
            <td>Fuente:</td>
            <td align="center"><label for="textfield3"></label>
            <label for="slctSource"></label>
            <select name="slctSource" id="slctSource">
            <?php 
			
	    	foreach (ScrapingService::getSourcesAndId() as $arrayKey => $arrayValue) {
				$optionId[] = $arrayKey;
				$optionValue[] = $arrayValue;
			}
	
			$optionIndex = 0;			
			while (!is_null($optionId[$optionIndex])) {
				echo "<option value='$optionId[$optionIndex]'>$optionValue[$optionIndex]</option>";
				$optionIndex++;
			}
			
			?> 
            </select></td>
          </tr>
          <tr>
            <td>Fecha:</td>
            <td align="center"><label for="radioHasScraper"></label>
            <label for="radioHasScraper">
              <input name="txtDate" type="text" id="txtDate" value="<?php echo $temporaryEncounterData[1]; ?>" size="50" maxlength="300" readonly="readonly" />
            </label></td>
          </tr>
          <tr>
            <td>Hora:</td>
            <td align="center"><p>
              <select name="slctHour" id="slctHour">
	            <?php 

				$result = EncounterService::getEncounterHourAndId();
				while ($line = mysql_fetch_array($result, MYSQL_NUM)) {
					echo "<option value='$line[0]'>$line[1]</option>";					
				}
		
				?>      
              </select>
              <br />
            (Hora registrada: <?php echo $temporaryEncounterData[2]; ?>)</p></td>
          </tr>
          <tr>
            <td>Duración:</td>
            <td align="center">
            <select name="slctDuration" id="slctDuration">
            <?php 

			foreach (EncounterService::getEncounterDurationAndId() as $arrayKey => $arrayValue) {
				echo "<option value='$arrayKey'>$arrayValue</option>";
			}
		
			?>            
            </select></td>
          </tr>
          <tr>
            <td>Localización (admin):</td>
            <td align="center"><label for="slctLocalization"></label>
            <select name="slctLocalization" id="slctLocalization">
            <?php 

			foreach (EncounterService::getEncounterLocalizationAndId() as $arrayKey => $arrayValue) {
				echo "<option value='$arrayKey'>$arrayValue</option>";
			}
		
			?>
            </select></td>
          </tr>
          <tr>
            <td>Microlocalización:</td>
            <td align="center">
            <select name="slctMicrolocalization" id="slctMicrolocalization">
            <?php 

			foreach (EncounterService::getEncounterMicroLocalizationAndId() as $arrayKey => $arrayValue) {
				echo "<option value='$arrayKey'>$arrayValue</option>";
			}
		
			?>
            </select></td>
          </tr>
          <tr>
            <td>Tipo de encuentro:</td>
            <td align="center"><select name="slctEncounterType" id="slctEncounterType">
            <?php 

			foreach (EncounterService::getEncounterTypesAndId() as $arrayKey => $arrayValue) {
				echo "<option value='$arrayKey'>$arrayValue</option>";
			}
		
			?>
            
            </select></td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <table border="0" align="center">
          <tr>
            <td><input name="boxDelete" type="checkbox" id="boxDelete" value="1" checked="checked" />
              <label for="boxDelete"></label>
Eliminar encuentro temporal (web-scraping)</td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <table border="0" align="center">
          <tr>
            <td><input type="submit" name="btnSubmit" id="btnSubmit" value="Guardar encuentro" />
            <input type="reset" name="btnClear" id="btnClear" value="Reiniciar" /></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<p></p>


<footer>
 <p align="right"><a href="temporaryEncounters.php">Volver</a> <a href="index.php">Salir</a></p>
</footer>

</body>
</html>

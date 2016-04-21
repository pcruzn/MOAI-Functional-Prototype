<?php
include ("moai_db_connection.php");
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
<h3>Ingreso de fuente de 'scraping'</h3>
<form id="scrapingSourceAddForm" name="scrapingSourceAddForm" method="post" action="scrapingSourceAdd.php?action=1">
  <p>&nbsp;</p>
  <table border="0" align="center">
    <tr>
      <td><p>&nbsp;</p>
        <table width="481" border="1" align="center">
          <tr>
            <td width="144">Nombre:</td>
            <td width="327" align="center"><label for="txtScrapingSourceName"></label>
              <input name="txtScrapingSourceName" type="text" id="txtSourceName" size="50" maxlength="300" /></td>
          </tr>
          <tr>
            <td>URL:</td>
            <td align="center"><label for="textfield3"></label>
              <input name="txtSourceURL" type="text" id="textfield3" size="50" maxlength="300" /></td>
          </tr>
          <tr>
            <td>¿Tiene scraper?</td>
            <td align="center"><table border="0">
              <tr>
                <td>Si</td>
                <td><input type="radio" name="radioHasScraper" id="radio" value="scraperTrue" /></td>
              </tr>
              <tr>
                <td>No</td>
                <td><input name="radioHasScraper" type="radio" id="radio2" value="scraperNotTrue" checked="checked" /></td>
              </tr>
            </table>
              
                <label for="radioHasScraper"></label>
                <label for="radioHasScraper"></label>
              
              </td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <table border="0" align="center">
          <tr>
            <td><input type="submit" name="btnSubmit" id="btnSubmit" value="Guardar" />
            <input type="reset" name="btnClear" id="btnClear" value="Reiniciar" /></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>

<?php

if ($_GET['action'] == 1) {
	
	// CAUTION: for now, has scraper is always 0!
	if (ScrapingService::addScrapingSource($_POST['txtScrapingSourceName'], $_POST['txtSourceURL'], 0) == 1)
		echo "Fuente agregada exitosamente...";
	
		
}


?>

<footer>
  <p align="right"><a href="moai.php">Volver al inicio</a> <a href="index.php">Salir</a></p>
</footer>

</body>
</html>

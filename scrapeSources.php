<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
include('header.php');
?>
<h3>Scrapear fuentes</h3>
<form action="scrapingSourceAdd.php" class="form-actions">
<p>Seleccione una fuente:
<p><a href="scrapeElMostrador.php">El Mostrador</a>
<p><a href="scrapeEmol.php">Emol</a>
<p><a href="scrapeGeneric.php">Scrapeo de fuentes del catálogo</a>


    <button type="submit" href="scrapingSourceAdd.php" class="btn btn-inverse pull-right">Agregar nueva Fuente</button>
</form>

<?php
include('footer.html');

<?php
include ("moai_db_connection.php");
include ("models/scrapingService.php");
include ("header.php")
?>

  <h3>Ingreso de fuente de 'scraping'</h3>
  <div class="row">
    <div class="span6">
      <?php

      if ($_GET['action'] == 1) {

        // CAUTION: for now, has scraper is always 0!
        if (ScrapingService::addScrapingSource($_POST['txtScrapingSourceName'], $_POST['txtSourceURL'], 0) == 1)
          echo "<div class=\"alert alert-info moai-alert\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
                                    Fuente agregada exitosamente...
                                </div>";


      }?>
      <form class="form-horizontal" id="scrapingSourceAddForm" name="scrapingSourceAddForm" method="post" action="scrapingSourceAdd.php?action=1">
        <div class="control-group small">
          <label class="control-label" for="txtScrapingSourceName">Nombre</label>
          <div class="controls">
            <input name="txtScrapingSourceName" type="text" id="txtSourceName" class="span2" maxlength="300" />
          </div>
        </div>
        <div class="control-group small">
          <label class="control-label" for="textfield3">Url</label>
          <div class="controls">
            <input name="txtSourceURL" type="text" id="textfield3" class="span3" maxlength="300" />
          </div>
        </div>
        <div class="control-group small">
          <label class="control-label" for="textfield3">¿Tiene Scraper?</label>
          <div class="controls">
            <label class="radio">
              <input type="radio" name="radioHasScraper" id="radio" value="scraperTrue" data-toggle="radio"/>Si
            </label>

            <label class="radio">
              <input name="radioHasScraper" type="radio" id="radio2" value="scraperNotTrue" checked="checked" data-toggle="radio" />No
            </label>
          </div>
        </div>
        <div class="controls small">
          <button type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-primary">Guardar</button>
          <button type="reset" name="btnClear" id="btnClear" class="btn btn-inverse">Reiniciar</button>
        </div>

      </form>
    </div>
  </div>

<?php


include("footer.html");

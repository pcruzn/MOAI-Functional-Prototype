<?php
include ("moai_db_connection.php");
include ("models/encounterService.php");
include ("models/scrapingService.php");
include ("header.php");
?>

    <style type="text/css">
        .controls > .checkbox:first-child {
            padding-top: 0px;
        }
    </style><h3>Modelado de Encuentro</h3>

<?php

if ($_GET['action'] == 1) {

// this MUST BE changed!
    $_POST['slctSource'] = 7;

// CAUTION: for now, has scraper is always 0!
    if (EncounterService::storeEncounter($_POST['slctSource'], $_POST['txtDescription'], $_POST['txtDate'], $_POST['slctHour'], $_POST['slctDuration'], $_POST['slctLocalization'], $_POST['slctMicrolocalization'], $_POST['slctEncounterType']) == 1) {

        if ($_POST['boxDelete'] == 1) {
            // for now, we haven't decided what to do with eligible encounters
            // will they be hidden? deleted?
            // EncounterService::deleteTemporaryEncounterById($_GET['sourceId']);
            ScrapingService::setScrapedDataAsNotEligible(array($_GET['sourceId']));
        }

        echo "<meta http-equiv='refresh' content='0;url=temporaryEncounters.php'>";

    }

}

?>

<?php

$temporaryEncounterDataDescriptor = EncounterService::getTemporaryEncounterById($_GET['id']);
$temporaryEncounterData = mysql_fetch_array($temporaryEncounterDataDescriptor, MYSQL_NUM);

?>
<div class="span6">
    <form id="form1" name="form1" method="post" action="encounterAdd.php?action=1&sourceId=<?php echo $_GET['id']; ?>" class="form-horizontal">
        <div class="control-group small">
            <label class="control-label" for="txtSourceName">Descripción</label>
            <div class="controls">
                <input name="txtDescription" type="text" placeholder="Descripción" class="span5" id="txtSourceName" value="<?php echo $temporaryEncounterData[0]; ?>">
            </div>
        </div>
        <div class="control-group small">
            <label class="control-label" for="txtDate">Fecha</label>
            <div class="controls small disabled">
                <input name="txtDate" id="inputPassword" type="text" id="txtDate" placeholder="Fecha" class="span2" readonly id="txtDate" value="<?php echo $temporaryEncounterData[1]; ?>">
                <i class="input-icon fui-lock"></i>
            </div>
        </div>
        <div class="control-group small">
            <label class="control-label" for="slctHour">Hora</label>
            <div class="controls">
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
            </div>
        </div>
        <div class="control-group small">
            <label class="control-label" for="slctDuration">Duración</label>
            <div class="controls">
                <select name="slctDuration" id="slctDuration">
                    <?php

                    $result = EncounterService::getEncounterDurationAndId();
                    while ($line = mysql_fetch_array($result, MYSQL_NUM)) {
                        echo "<option value='$line[0]'>$line[1]</option>";
                    }

                    ?>
                </select>
            </div>
        </div>
        <div class="control-group small">
            <label class="control-label" for="slctLocalization">Localización (admin)</label>
            <div class="controls">
                <select name="slctLocalization" id="slctLocalization">
                    <?php

                    $result = EncounterService::getEncounterLocalizationAndId();
                    while ($line = mysql_fetch_array($result, MYSQL_NUM)) {
                        echo "<option value='$line[0]'>$line[1]</option>";
                    }

                    ?>
                </select>
            </div>
        </div>
        <div class="control-group small">
            <label class="control-label" for="slctMicrolocalization">Microlocalización</label>
            <div class="controls">
                <select name="slctMicrolocalization" id="slctMicrolocalization">
                    <?php

                    $result = EncounterService::getEncounterMicroLocalizationAndId();
                    while ($line = mysql_fetch_array($result, MYSQL_NUM)) {
                        echo "<option value='$line[0]'>$line[1]</option>";
                    }

                    ?>
                </select>
            </div>
        </div>
        <div class="control-group small">
            <label class="control-label" for="slctEncounterType">Tipo de encuentro:	</label>
            <div class="controls">
                <select name="slctEncounterType" id="slctEncounterType">
                    <?php

                    $result = EncounterService::getEncounterTypesAndId();
                    while ($line = mysql_fetch_array($result, MYSQL_NUM)) {
                        echo "<option value='$line[0]'>$line[1]</option>";
                    }

                    ?>

                </select>
            </div>
        </div>
        <div class="control-group small">
            <div class="controls">
                <label class="checkbox primary asdasd" for="boxDelete">
                    <input type="checkbox" checked="checked" name="boxDelete" id="boxDelete" value="1" data-toggle="checkbox" checked=""/>
                    Eliminar encuentro (desde web-scraping)
                </label>
                <button type="submit" name="btnSubmit" id="btnSubmit"class="btn btn-inverse">Guardar Encuentro</button>
                <button type="reset" name="btnClear" id="btnClear" class="btn btn-inverse">Reiniciar</button>
            </div>
        </div>
    </form>
</div>
<?php
include ("footer.html");

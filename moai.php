<?php
include("header.php")
?>

    <h5>Bienvenido al software prototipo de MOAI</h5>
    <br>
    <p>Podra ejecutar MOAI en los siguientes 4 pasos:</p>


    <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step">
                <a href="scrapeSources.php" type="button" class="fui-gear btn btn-primary btn-circle"></a>
                <p>Scraping</p>
            </div>
            <div class="stepwizard-step">
                <a href="selectEncounter.php" type="button" class="fui-list-bulleted btn btn-primary btn-circle"></a>
                <p>Selección</p>
            </div>
            <div class="stepwizard-step">
                <a href="temporaryEncounters.php" type="button" class="fui-link btn btn-primary btn-circle"></a>
                <p>Modelamiento</p>
            </div>
            <div class="stepwizard-step">
                <a href="encounterAnalysis.php" type="button" class="fui-eye btn btn-primary btn-circle"></a>
                <p>Reporte</p>
            </div>
        </div>
    </div>

    <br>
    <br>
    <br>
    <div class="offset2 span3">Además de <a href="facetedSearch.php" > Búsqueda por facetas <span class="fui-search"/></a></div>




<?php
include ("footer.html");

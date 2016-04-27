<?php
include ("moai_db_connection.php");
include ("models/encounterService.php");
include ("models/scrapingService.php");

function get_temporal_encounter_list()
{
    $rs = EncounterService::getAllTemporaryEncounters();
    $rows = array();
    while($r = mysql_fetch_assoc($rs)) {
        $rows[] = $r;
    }
    return $rows;
}

function select_temporal_encounter($selectedEncountersId){
    ScrapingService::setScrapedDataAsSelected($selectedEncountersId);
    return $selectedEncountersId;
}

function drop_temporal_encounter($selectedEncountersId){
    ScrapingService::setScrapedDataAsNotEligible($selectedEncountersId);
    return $selectedEncountersId;
}
$possible_url = array("get_temporal_encounter_list", "get_app", "Seleccionar", "Eliminar");

$value = "An error has occurred";

if (isset($_GET["action"]) && in_array($_GET["action"], $possible_url))
{
    switch ($_GET["action"])
    {
        case "get_temporal_encounter_list":
            $value = get_temporal_encounter_list();
            break;
        case "Seleccionar":
            if (isset($_GET["selectedEncounters"])) {
                $value = is_array($_GET["selectedEncounters"]);
                $value = select_temporal_encounter($_GET["selectedEncounters"]);
                header("selectEncounter.php");
            }
            else
                $value = "Missing argument";
            break;
        case "Eliminar":
            if (isset($_GET["selectedEncounters"])) {
                $value = is_array($_GET["selectedEncounters"]);
                $value = drop_temporal_encounter($_GET["selectedEncounters"]);
            }
            else
                $value = "Missing argument";
            break;
        case "get_app":
            if (isset($_GET["id"]))
                $value = get_app_by_id($_GET["id"]);
            else
                $value = "Missing argument";
            break;
    }
}

//return JSON array
//exit(json_encode($value));
echo "<meta http-equiv='refresh' content='0;url=temporaryEncounters.php'>";
?>

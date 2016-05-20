<?php
error_reporting(-1);
include ("moai_db_connection.php");
include ("models/encounterService.php");
include ("models/SocioService.php");
include ("header.php");
//


if($_POST['action']==1) {

//    echo $_POST['selectProperty'];
//    echo $_POST['groupName'];
//    echo implode(' ',$_POST['groupValues']);
    $childValues = $_POST['groupValues'];
    $property = $_POST['selectProperty'];
    $groupName = $_POST['groupName'];

    $xml = new SimpleXmlElement("models/groups.xml", null, true) or die("Error: Cannot create XML object");
    $group = $xml->addChild('group');

    $group->addAttribute('tableAndColumnName', $property);
    $group->addAttribute('user', 'demo');
    $group->addAttribute('name', $groupName);

    foreach ($childValues as $childValue) {
        $child = $group->addChild('child', $childValue);
    }

//$xml->saveXML("/Users/maliq/Documents/moia/MOAI-Functional/models/groups2.xml");
//echo $xml->asXML()

    $dom = new DOMDocument('1.0');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xml->asXML());
    $dom->save("models/groups.xml");
}
if($_GET['action']==2) {
    $groupName = $_GET['groupName'];
    $doc = new DOMDocument;
    $doc->load("models/groups.xml");

    $thedocument = $doc->documentElement;

//this gives you a list of the messages
    $list = $thedocument->getElementsByTagName('group');

//figure out which ones you want -- assign it to a variable (ie: $nodeToRemove )
    $nodeToRemove = null;
    foreach ($list as $domElement) {
        $attrValue = $domElement->getAttribute('name');
        if ($attrValue == $groupName) {
            $nodeToRemove = $domElement; //will only remember last one- but this is just an example :)
        }
    }

//Now remove it.
    if ($nodeToRemove != null)
        $thedocument->removeChild($nodeToRemove);

    $doc->save("models/groups.xml");
}

?>

    <h3>Agrupaciones</h3>
    <div class="btn-group" data-toggle="buttons-checkbox">
        <button class="btn btn-small btn-primary" href="#myModal" data-toggle="modal" >Crear agrupación</button>
<!--        <button onclick="resetGroup()" class="btn btn-small btn-primary">Reset agrupación</button>-->
    </div>
    <!-- Button to trigger modal -->
    <br/>

    <table class="table table-bordered" >
        <thead>
        <tr>
            <th>Agrupación</th>
            <th>Valores</th>
            <th>Propiedad</th>
            <th>Cantidad Encuentros</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $xml = simplexml_load_file("models/groups.xml") or die("Error: Cannot create XML object");
        foreach($xml->children() as $father) {
            $childrenCount = array();
            $tableAndColumnName = $father['tableAndColumnName'];
            $groupName = $father['name'];
            echo "<tr>";
            echo "<td>$groupName</td>";
            echo "<td><ul>";
            foreach ($father as $instance) {
                echo "<li>$instance</li>";
                array_push ($childrenCount, (int) SocioService::getCountByChildAttributeOnTable($instance, $tableAndColumnName));
            }
            echo "</ul></td>";
            echo "<td>$tableAndColumnName</td>";
            echo "<td>" . array_sum($childrenCount) . "</td>";
            echo "<td><a href='createGroup.php?action=2&groupName=$groupName'><button class='btn btn-danger'>Eliminar</button></a></td>";
        }
        ?>
        </tbody>
    </table>


    <!-- Modal -->
    <div id="myModal" class="modal hide fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h6 id="myModalLabel">Crear Agrupación</h6>
        </div>
        <div class="modal-body" style="min-height: 250px;">
            <div id="groupError"></div>
            <form action="createGroup.php" id="groupForm" method="POST">
<!--                <label class="control-label" for="selectProperty">Propiedad</label>-->
                <div class="control-group">
                    <select id="selectProperty" name="selectProperty" class="select-inline" onchange="loadForm()">
                        <option value="NoSourceFilter" selected="selected">Seleccione Propiedad</option>
                        <option value='Hora'>Hora Encuentro</option>
                        <option value='Tipo_Encuentro'>Tipo Encuentro</option>
                        <option value='Localizacion_Administrativa'>Localización Encuentro</option>
                        <option value='MicroLocalizacion'>Micro Localización Encuentro</option>
                    </select>
                </div>
                <div id="checklistDiv" class="control-group"></div>
                <input id="groupName" type="text" name="groupName" placeholder="Nombre Agrupación" class="span3 small"/>
                <input type="hidden" value="1" name="action"/>
            </form>

        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-primary" id="createBotton" onclick="createGroup()">Crear</button>
        </div>
    </div>

<?php

$encounterTypes = array();
$encounterTypesCount = array();
foreach (EncounterService::getEncounterTypesCount() as $arrayKey => $arrayValue) {
    $encounterTypes[] = $arrayKey;
    $encounterTypesCount[] = $arrayValue;
}

$encounterHours = array();
$encounterHoursCount = array();

foreach (EncounterService::getEncounterHoursCount() as $arrayKey => $arrayValue) {
    $encounterHours[] = $arrayKey;
    $encounterHoursCount[] = $arrayValue;
}

$encounterLocalization = array();
$encounterLocalizationCount = array();

foreach (EncounterService::getEncounterLocalizationCount() as $arrayKey => $arrayValue) {
    $encounterLocalization[] = $arrayKey;
    $encounterLocalizationCount[] = $arrayValue;
}

$encounterMicroLocalization = array();
$encounterMicroLocalizationCount = array();

foreach (EncounterService::getEncounterMicroLocalizationCount() as $arrayKey => $arrayValue) {
    $encounterMicroLocalization[] = $arrayKey;
    $encounterMicroLocalizationCount[] = $arrayValue;
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


        var propertyValues = <?php echo json_encode($encounterTypes); ?>;
        var propertyCount = <?php echo json_encode($encounterTypesCount); ?>;
        var _propertyValues = propertyValues;
        var _propertyCount = propertyCount;
        var encounterTypes = <?php echo json_encode($encounterTypes); ?>;
        var encounterTypesCount = <?php echo json_encode($encounterTypesCount); ?>;
        var encounterHours = <?php echo json_encode($encounterHours); ?>;
        var encounterHoursCount = <?php echo json_encode($encounterHoursCount); ?>;
        var encounterLocalization = <?php echo json_encode($encounterLocalization); ?>;
        var encounterLocalizationCount = <?php echo json_encode($encounterLocalizationCount); ?>;
        var encounterMicroLocalization = <?php echo json_encode($encounterMicroLocalization); ?>;
        var encounterMicroLocalizationCount = <?php echo json_encode($encounterMicroLocalizationCount); ?>;


        function selectProperty() {
            var property = $("#selectProperty").val();
            switch(property){
                case "Hora":
                    propertyValues = encounterHours;
                    propertyCount = encounterHoursCount;
                    break;
                case "Tipo_Encuentro":
                    propertyValues = encounterTypes;
                    propertyCount = encounterTypesCount
                    break;
                case "Localizacion_Administrativa":
                    propertyValues = encounterLocalization;
                    propertyCount = encounterLocalizationCount;
                    break;
                case "MicroLocalizacion":
                    propertyValues = encounterMicroLocalization;
                    propertyCount = encounterMicroLocalizationCount;
                    break;
                default:
                    propertyValues = []
                    propertyCount = []

            }
        }
        
        
        function loadForm() {
            var zip =[];
            selectProperty()
            $("#checklistDiv").html("")
            for (var i = 0; i < propertyValues.length; i++) {
                zip.push([propertyValues[i], propertyCount[i]]);
                var checkboxHtml = String.format('<label class="checkbox" for="checkbox1"> <input type="checkbox" name="groupValues[]" value="{1}" id="checkbox{0}" data-count="{2}" data-toggle="checkbox"> {1}</label>',
                    i+1, propertyValues[i], propertyCount[i]);
                $("#checklistDiv").append(checkboxHtml);
            }
            $('[data-toggle="checkbox"]').each(function () {
                var $checkbox = $(this);
                $checkbox.checkbox();
            });
        }

        function resetGroup() {
            propertyValues = _propertyValues;
            propertyCount = _propertyCount;
            resetCanvas();
            createChar();
        }

        function createGroup() {
            var encounterTypes_ = []
            var encounterTypesCount_ = []
            var groupCount = 0;
            $("#checklistDiv input").each( function() {
                if (!$(this).is(':checked')){
                    encounterTypes_.push($(this).val());
                    encounterTypesCount_.push($(this).attr("data-count"));
                }else{
                    groupCount += parseInt($(this).attr("data-count"));
                }
            });
            var groupName = $("#groupName").val();
            if(groupCount>0 && groupName != ""){
                $('#groupForm').submit()
            }else{
                $("#groupError").append('<div class="alert alert-error moai-alert"><button type="button" class="close" data-dismiss="alert">&times;</button> No ingresado nombre o selección. </div>');
            }

        }

        $( document ).ready(function() {
            $("#selectProperty").selectpicker({style: 'btn-primary select-inline'});
        });

    </script>

<?php
include ("footer.html");
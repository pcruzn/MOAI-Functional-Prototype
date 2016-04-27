<?php
error_reporting(-1);
include('header.php');
include("moai_db_connection.php");
include("models/scrapingService.php");
include("models/encounterService.php");
?>

<script src="bower_components/angular/angular.js"></script>
<script type="application/javascript">
    angular.module('moaiApp', [])
        .controller('EncounterControllerAjax', function($http) {
            var encounter = this;

            $http({method: 'GET', url: 'http://localhost:63342/MOAI-Functional/encounter_api.php?action=get_temporal_encounter_list'}).success(function(data)
            {
                encounter.encounterList = data; // response data
            });

            encounter.check = function() {
                for(i = 0; i < encounter.encounterList.length; i++) {
                    var e = encounter.encounterList[i];
                    console.log(e.id+"check:"+e.checked);
                }
            }
        });
</script>
<h4>Selección de Encuentros</h4>
<form action="selectEncounter.php" class="form-inline" method="post">
    <input type="text" class="span2 search-query search-query-rounded" placeholder="Palabra clave" <?php
    // if a search was made, remember the keyword in the text field
    if ($_POST['txtSearchKeyword'] != '') {
        $keywordFromForm = $_POST['txtSearchKeyword'];
        echo "value=$keywordFromForm";
    }
    ?> id="search-query-7" name="txtSearchKeyword">
    <label for="from">Desde:</label>
    <div class="input-prepend input-datepicker">
        <button type="button" class="btn"><span class="fui-calendar"></span></button>
        <input type="text" name="from" class="span2" id="datepicker-01" <?php
        // if a search was made, remember the keyword in the text field
        if ($_POST['from'] != '') {
            $keywordFromForm = $_POST['from'];
            echo "value=$keywordFromForm";
        }
        ?>>
    </div>
    <label for="to">Hasta:</label>
    <div class="input-prepend input-datepicker">
        <button type="button" class="btn"><span class="fui-calendar"></span></button>
        <input type="text" name="to" class="span2" id="datepicker-02"<?php
        // if a search was made, remember the keyword in the text field
        if ($_POST['to'] != '') {
            $keywordFromForm = $_POST['to'];
            echo "value=$keywordFromForm";
        }
        ?>>>
    </div>
    <div class=control-group>
        <label for="selectEncounterSourceFilter">Fuente:</label>
        <select name="selectEncounterSourceFilter">
            <option value="NoSourceFilter" selected="selected">Sin filtrado</option>
            <?php
            $querySources = "SELECT id, fuente FROM fuente";
            $result = mysql_query($querySources) or die('Consulta fallida: ' . mysql_error());

            // in case a search was made and a filter was selected, remember the filter criteria
            while ($line = mysql_fetch_array($result, MYSQL_NUM)) {
                if ($line[0] == $_POST['selectEncounterSourceFilter'])
                    echo "<option value='$line[0]' selected='selected'>$line[1]</option>";
                else
                    echo "<option value='$line[0]'>$line[1]</option>";
            }

            ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Buscar</button>
</form>
<form id="encountersForm" action="encounter_api.php">
    <div ng-controller="EncounterControllerAjax as encounter">
        <input hidden id="action" name="action" value="select">
        <div class="btn-toolbar">
            <div class="btn-group" id="actionBar">
                <a class="btn btn-primary" href="#" data-toggle="tooltip" title="Seleccionar"><i class="fui-check-inverted"></i></a>
                <a class="btn btn-primary" href="#" data-toggle="tooltip" title="Evaluar"><i class="fui-eye"></i></a>
                <a class="btn btn-primary" href="#" data-toggle="tooltip" title="Eliminar"><i class="fui-cross-inverted"></i></a>
            </div>
        </div> <!-- /toolbar -->

        <table class="table table-bordered" >
            <thead>
            <tr>
                <th><label class="checkbox no-label toggle-all" for="checkbox-table-1"><input type="checkbox" value="" id="checkbox-table-1" data-toggle="checkbox"></label></th>
                <th>Descripción</th>
                <th>Fecha Obtención</th>
                <th>Fuente</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $rs = EncounterService::getAllAvailableTemporaryEncounters();
//            while ($line = mysql_fetch_array($rs, MYSQL_NUM)) {
//                echo "\t<tr>\n";
//                echo "\t\t<td>$line[1] (ver detalles)</td>\n";
//                echo "\t</tr>\n";
//            }
            $index = 1;
            while($r = mysql_fetch_array($rs, MYSQL_NUM)) {
                echo "\t<tr>\n";
                echo "\t<td><label class='checkbox no-label' for='checkbox-table-$index'><input name='selectedEncounters[]' value='$r[0]' type='checkbox' id='checkbox-table-$index' data-toggle='checkbox'></label></td>\n";
                if(strlen($r[5])>0)
                    echo "\t\t<td><a href='$r[5]' target='_blank'>$r[1]</a></td>\n";
                else
                    echo "\t\t<td>$r[1]</td>\n";
                echo "\t\t<td>$r[2]</td>\n";
                echo "\t\t<td>$r[4]</td>\n";
                echo "\t</tr>\n";
                $index = $index+1;
            }
            ?>
            </tbody>
        </table>
    </div>
</form>


<script type="application/javascript">
    $( document ).ready(function() {
        // jQuery UI Datepicker
        $('#datepicker-01').datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            dateFormat: "dd/mm/yy",
            yearRange: '-1:+1'
        }).prev('.btn').on('click', function (e) {
            e && e.preventDefault();
            $('#datepicker-01').focus();
        });
        $('#datepicker-02').datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            dateFormat: "dd/mm/yy",
            yearRange: '-1:+1'
        }).prev('.btn').on('click', function (e) {
            e && e.preventDefault();
            $('#datepicker-02').focus();
        });

        $('[data-toggle="tooltip"]').tooltip({container: 'body'})
        // Table: Toggle all checkboxes
        $('.table .toggle-all').on('click', function() {
            var ch = $(this).find(':checkbox').prop('checked');
            $(this).closest('.table').find('tbody :checkbox').checkbox(!ch ? 'check' : 'uncheck');
        });
        // Table: Add class row selected
        $('.table tbody :checkbox').on('check uncheck toggle', function (e) {
            var $this = $(this)
                , check = $this.prop('checked')
                , toggle = e.type == 'toggle'
                , checkboxes = $('.table tbody :checkbox')
                , checkAll = checkboxes.length == checkboxes.filter(':checked').length

            $this.closest('tr')[check ? 'addClass' : 'removeClass']('selected-row');
            if (toggle) $this.closest('.table').find('.toggle-all :checkbox').checkbox(checkAll ? 'check' : 'uncheck');
        });

        $('#actionBar a').on('click',function () {
            value = $(this).attr('data-original-title');
            $('#action').val(value);
            $('#encountersForm').submit();
        })
    });
</script>

<?php
include('footer.html');
?>

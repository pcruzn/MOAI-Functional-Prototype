<?php
error_reporting(-1);
include('header.php');
include("moai_db_connection.php");
include("models/scrapingService.php");
include("models/encounterService.php");
?>

<h4>Selección de Encuentros</h4>
<form action="selectEncounter.php" class="form" method="post">
    <div class="row">
        <div class="offset1 span4">
            <div class="control-group">
                <input type="text" class="span1 search-query search-query-rounded" placeholder="Palabra clave" <?php
                // if a search was made, remember the keyword in the text field
                if ($_POST['txtSearchKeyword'] != '') {
                    $keywordFromForm = $_POST['txtSearchKeyword'];
                    echo "value=$keywordFromForm";
                }
                ?> id="search-query-7" name="txtSearchKeyword">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="offset1 span4">
            <div class="control-group">
                <div class="input-prepend input-datepicker">
                    <button type="button" class="btn"><span class="fui-calendar"></span></button>
                    <input type="text" name="from" class="span2" id="datepicker-1" placeholder="Desde" <?php
                    // if a search was made, remember the keyword in the text field
                    if ($_POST['from'] != '') {
                        $from = $_POST['from'];
                        echo "value=$from";
                    }
                    ?>>
                </div>
            </div>
        </div>
        <div class="span4">
            <div class="control-group">
                <select name="selectEncounterSourceFilter" class="select-block" data-toggle="tooltip" title="Fuente">
                    <option value="NoSourceFilter" selected="selected">Sin filtrado</option>
                    <?php
                    $querySources = "SELECT DISTINCT fuente FROM encuentro_temporal";
                    $result = mysql_query($querySources) or die('Consulta fallida: ' . mysql_error());

                    // in case a search was made and a filter was selected, remember the filter criteria
                    while ($line = mysql_fetch_array($result, MYSQL_NUM)) {
                        if ($line[0] == $_POST['selectEncounterSourceFilter']) {
                            $source = $line[0];
                            echo "<option value='$line[0]' selected='selected'>$line[0]</option>";
                        }else
                            echo "<option value='$line[0]'>$line[0]</option>";
                    }

                    ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="offset1 span3">
            <div class="control-group">
                <div class="input-prepend input-datepicker">
                    <button type="button" class="btn"><span class="fui-calendar"></span></button>
                    <input type="text" name="to" class="span2" id="datepicker-2" placeholder="Hasta" <?php
                    // if a search was made, remember the keyword in the text field
                    if ($_POST['to'] != '') {
                        $to = $_POST['to'];
                        echo "value=$to";
                    }
                    ?>>>
                </div>
            </div>

        </div>
        <div class="offset1 span4">
            <button type="submit" class="btn btn-small btn-primary">Buscar</button>
        </div>
    </div>

</form>
<hr>
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
                <th style="white-space: nowrap;overflow: hidden;">Fecha Obtención</th>
                <th>Fuente</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $rs = EncounterService::filterTemporaryEncounters(1, $keywordFromForm, $source, $from, $to );
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
        $('#datepicker-1').datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            dateFormat: "dd/mm/yy",
            yearRange: '-1:+1'
        }).prev('.btn').on('click', function (e) {
            e && e.preventDefault();
            $('#datepicker-01').focus();
        });
        $('#datepicker-2').datepicker({
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

        $("select[name='selectEncounterSourceFilter']").selectpicker({style: 'btn-small btn-primary'});
    });
</script>

<?php
include('footer.html');
?>

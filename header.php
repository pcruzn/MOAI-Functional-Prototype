<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>MOAI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Loading Bootstrap -->
    <link href="Flat-UI/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="Flat-UI/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="Flat-UI/css/flat-ui.css" rel="stylesheet">

    <link rel="shortcut icon" href="moai_icon.ico">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <script src="Flat-UI/js/html5shiv.js"></script>
    <![endif]-->
    <script src="Flat-UI/js/jquery-1.8.3.min.js"></script>
</head>
<body>
<div class="container-fluid">
    <div class="navbar navbar-inverse">
        <div class="navbar-inner">
            <div class="container">
                <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target="#nav-collapse-02">
                </button>
                <a href="moai.php" class="brand">MOAI</a>
                <div class="nav-collapse collapse" id="nav-collapse-02">
                    <form class="navbar-search form-search pull-right" action="searchByKeyword.php?tipo=1" method="post">
                        <div class="input-append">
                            <input type="text" class="search-query span2" name="txtSearchKeyword"
                            <?php
                                // if a search was made, remember the keyword in the text field
                                if ($_POST['txtSearchKeyword'] != '') {
                                    $keywordFromForm = $_POST['txtSearchKeyword'];
                                    echo "value=$keywordFromForm";
                                }
                            ?>
                            placeholder="Buscar"/>
                            <button type="submit" class="btn btn-large">
                                <i class="fui-search"></i>
                            </button>
                        </div>
                    </form>

                    <ul class="nav pull-right">
                        <li class="active">
                            <a href="#fakelink">
                                <span class="fui-user"></span><span class="hidden-desktop">My Account</span>
                            </a>
                        </li>
                        <li>
                            <a href="index.php">
                                <span class="fui-power"></span><span class="hidden-desktop">Salir</span>
                            </a>
                        </li>
                        <li>
                            <a href="#fakelink">
                                <span class="fui-gear"></span><span class="hidden-desktop">Settings</span>
                            </a>
                        </li>
                    </ul> <!-- /nav -->
                </div><!--/.nav-collapse -->
            </div>
        </div>
    </div> <!-- /navbar -->

    <div class="row-fluid">
        <div class="span1">
            <div class="iconbar">
                <ul>
                    <li><a href="facetedSearch.php" class="fui-search" data-toggle="tooltip" data-placement="right"  title="Busqueda faceteada"></a></li>
                    <li><a href="encounterHourHistogramChart.php" class="fui-list" data-placement="right" title="Histograma - Hora de Encuentros" data-toggle="tooltip"></a></li>
                    <li><a href="encounterDateTimeSeriesChart.php" class="fui-calendar" data-placement="right" title="Serie de Tiempo -  Encuentros por Fecha" data-toggle="tooltip"></a></li>
                    <li><a href="encounterTypeRadarChart.php" class="fui-list-bulleted" data-placement="right" title="Radar - Tipo de Encuentros" data-toggle="tooltip"></a></li>
                    <li><a href="encounterHourRadarChart.php" class="fui-time" title="Radar - Hora de Encuentros" data-placement="right"  data-toggle="tooltip"></a></li>
                    <li><a href="encounterLocalizationRadarChart.php" class="fui-location" title="Radar - Localización de Encuentros" data-placement="right"  data-toggle="tooltip"></a></li>
                    <li><a href="encounterMicrolocalizationHistogramChart.php" class="fui-location" title="Histograma - Microlocalización de encuentros" data-toggle="tooltip" data-placement="right" ></a></li>
                </ul>
            </div>
        </div>
        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip({
                    container: 'body'})
            })
        </script>
        <div class="span10">

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

    <!-- MOAI custom css-->
    <link rel="stylesheet" type="text/css" href="moai.css"/>

    <link rel="shortcut icon" href="moai_icon.ico">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <script src="Flat-UI/js/html5shiv.js"></script>
    <![endif]-->
    <script src="Flat-UI/js/jquery-1.8.3.min.js"></script>
    <style type="text/css">
        .iconbar .divider {
            background-color: #34495E;
            border-bottom: none;
            margin: 2px 0 5px;
            padding: 0;
            height: 2px;
        }
    </style>
</head>
<body>
<div class="container">
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
                    </ul> <!-- /nav -->
                </div><!--/.nav-collapse -->
            </div>
        </div>
    </div> <!-- /navbar -->

    <div class="row">
        <div class="span2">
            <div class="iconbar">
                <ul>
                    <li><a href="scrapeSources.php" class="fui-gear" data-placement="right" title="Configurar Scraper" data-toggle="tooltip"></a></li>
                    <li><a href="selectEncounter.php" class="fui-list-bulleted" data-placement="right" title="Selección" data-toggle="tooltip"></a></li>
                    <li><a href="temporaryEncounters.php" class="fui-link" data-placement="right" title="Modelado" data-toggle="tooltip"></a></li>
                    <li><a href="encounterAnalysis.php" class="fui-eye" data-placement="right" title="Reporte" data-toggle="tooltip"></a></li>
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

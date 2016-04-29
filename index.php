<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Loading Bootstrap -->
    <link href="Flat-UI/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="Flat-UI/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- MOAI custom css-->
    <link rel="stylesheet" type="text/css" href="moai.css"/>

    <!-- Loading Flat UI -->
    <link href="Flat-UI/css/flat-ui.css" rel="stylesheet">

    <link rel="shortcut icon" href="moai_icon.ico">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <script src="Flat-UI/js/html5shiv.js"></script>
    <![endif]-->
    <script src="Flat-UI/js/jquery-1.8.3.min.js"></script>
    <title>MOAI</title>
</head>

<body>

<div class="container">
    <div class="row">
        <div class="span6 offset3">
            <h4 class="text-center">Bienvenido a MOAI</h4>
            <form action="index.php?login=1" method="post" class="form-horizontal">
                <div class="control-group small">
                    <label class="control-label" for="txtSourceName">Usuario</label>
                    <div class="controls">
                        <input type="text" name="txtUserName" id="textfield" class="span3" />
                    </div>
                </div>
                <div class="control-group small">
                    <label class="control-label" for="txtSourceName">Contraseña</label>
                    <div class="controls">
                        <input type="password" name="txtPassword" id="textfield2" class="span3"/></td>
                    </div>
                </div>
                <div class="text-center">
                    <?php

                    if ($_GET['login'] == 1) {
                        $username = $_POST['txtUserName'];
                        $password = $_POST['txtPassword'];

                        // just for the prototype: check only one demo user
                        // no sessions, no special security
                        if ($username == "demo" && $password == "moaidemo") {
                            header('Location: ' . 'moai.php');
                            die();
                        }
                        else {
                            echo "<div class=\"alert moai-alert\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
                                    ¡Usuario o contraseña incorrecta!.
                                </div>";
                        }
                    }

                    ?>

                    <button type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-small btn-primary">Ingresar</button>
                    <button type="reset" name="btnReset" id="btnReset" class="btn btn-small btn-primary" >Limpiar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Load JS here for greater good =============================-->
<script src="Flat-UI/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="Flat-UI/js/jquery.ui.touch-punch.min.js"></script>
<script src="Flat-UI/js/bootstrap.min.js"></script>
<script src="Flat-UI/js/bootstrap-select.js"></script>
<script src="Flat-UI/js/bootstrap-switch.js"></script>
<script src="Flat-UI/js/flatui-checkbox.js"></script>
<script src="Flat-UI/js/flatui-radio.js"></script>
<script src="Flat-UI/js/jquery.tagsinput.js"></script>
<script src="Flat-UI/js/jquery.placeholder.js"></script>
<script src="Flat-UI/js/jquery.stacktable.js"></script>
</body>
</html>

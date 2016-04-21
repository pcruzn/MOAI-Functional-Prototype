<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="flat-ui.css" />
<title>MOAI</title>
</head>

<body>
<h1 align="center" >Bienvenido a MOAI</h1>
<div>
  <p>
    <label for="textfield"></label>
  </p>
  <form action="index.php?login=1" method="post">
    <table width="200" border="0" align="center">
      <tr>
        <td>Nombre de usuario:</td>
        <td><input type="text" name="txtUserName" id="textfield" /></td>
      </tr>
      <tr>
        <td>Contraseña:</td>
        <td><label for="textfield2"></label>
          <input type="password" name="txtPassword" id="textfield2" /></td>
      </tr>
    </table>
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
				echo "<p align='center'>¡Usuario o contraseña incorrecta!</p>";
			}		  
		}
		
  	?>
    <h1 align="center" >
      <input type="submit" name="btnSubmit" id="btnSubmit" value="Ingresar" />
      <input type="reset" name="btnReset" id="btnReset" value="Limpiar" />
    </h1>
  </form>
</div>
<p>&nbsp;</p>
</body>
</html>

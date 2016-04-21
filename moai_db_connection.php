<?php
// trying to connect to local db server
$dbLink = mysql_connect('localhost', 'moai', 'moai1234') or die('Problema al conectar a la base de datos: ' . mysql_error());

// if connection is ok, select moai database (else, die!)
mysql_select_db('moai_test') or die('No se pudo seleccionar la base de datos.');

// set utf8 as charset to avoid latin characters wrong printing
mysql_set_charset('utf8',$dbLink);
?>
<?php
// delete this when used in the system
// not required!
include ("../moai_db_connection.php");

class SocioService {
	// returns the count of a child attribute
	public static function getCountByChildAttributeOnTable($childAttribute, $tableAndColumnName) {
		$childCountStatement = 
		"SELECT COUNT(*) 
		FROM $tableAndColumnName, Encuentro
		WHERE Encuentro.$tableAndColumnName = $tableAndColumnName.id
		AND $tableAndColumnName.$tableAndColumnName = '$childAttribute'
		GROUP BY '$childAttribute'";
		
//		echo $childCountStatement . "\n";
		
		$result	 = 	mysql_query($childCountStatement) 
					or die('Consulta fallida: ' . mysql_error());
		

		$line = mysql_fetch_array($result, MYSQL_NUM);
	
		// if ok, it will return the count of $childAttribute in table Encuentro	
		return $line[0];
	}
}

?>
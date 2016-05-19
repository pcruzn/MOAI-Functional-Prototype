<?php
// delete this when used in the system
// not required!
include ("moai_db_connection.php");

class SocioService {
	// returns the count of a child attribute
	public static function getCountByChildAttributeOnTable($childAttribute, $tableAndColumnName) {
		$childCountStatement = 
		"SELECT COUNT(*) 
		FROM $tableAndColumnName, Encuentro
		WHERE Encuentro.$tableAndColumnName = $tableAndColumnName.id
		AND $tableAndColumnName.$tableAndColumnName = '$childAttribute'
		GROUP BY '$childAttribute'";
		
		echo $childCountStatement;
		
		$result	 = 	mysql_query($childCountStatement) 
					or die('Consulta fallida: ' . mysql_error());
		

		$line = mysql_fetch_array($result, MYSQL_NUM);
	
		// if ok, it will return the count of $childAttribute in table Encuentro	
		return $line[0];
	}
}

// next lines are for testing purposes only!
// you should include the following lines in your 'calling code/module'
$xml = simplexml_load_file("groups.xml") or die("Error: Cannot create XML object");

// this array will contain the count for each children
$childrenCount = array();

// catch all parents! (children() is a function of SimpleXML so it should not be confused with father and child in 
// the domain context
foreach($xml->children() as $father) { 
	$tableAndColumnName = $father['tableAndColumnName'];
    foreach ($father as $instance) {
		// a father has children
		// each child is here treated as an instance
		array_push ($childrenCount, (int) SocioService::getCountByChildAttributeOnTable($instance, $tableAndColumnName));	
	}	
	// echo children count!
	echo array_sum($childrenCount);
} 

?>
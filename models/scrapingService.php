<?php
// this class provides some services (TS pattern) for scraping operations

class ScrapingService {
	
	public static function addScrapingSource($sourceName, $sourceURL, $hasScraper) {
		// scraping sources were added long after 'fuente' table
		// therefore, procedure to add a scraping sources is the following:
		// 1) lock table scraping source in order to avoid concurrent insertions
		// 2) insert the scraping source 
		// 3) get the last id (auto increment) from scraping source (remember table is locked for writing!)
		// 4) unlock table scraping sources. remember this is required!! if not, you won't be able to work
		// with other tables
		// 5) insert the id and name into the table 'fuente'
		

		$lockScrapingSourcesTable = "LOCK TABLES scraping_source WRITE";
		mysql_query($lockScrapingSourcesTable) 
					or die('No ha sido posible bloquear tablas: ' . mysql_error());

		$addScrapingSource = "INSERT INTO 
							scraping_source(source_name, source_url, has_scraper) 
							VALUES ('$sourceName', '$sourceURL', $hasScraper)";
		
		$result	 = 	mysql_query($addScrapingSource) 
					or die('Consulta fallida: ' . mysql_error());
					
		$lastID = "SELECT MAX(id) as id FROM scraping_source";

		$result	 = 	mysql_query($lastID) 
					or die('Consulta fallida: ' . mysql_error());

		$id = mysql_result($result, 0, 'id');

		// befor using other tables, unlock tables!
		$unlockScrapingSourcesTable = "UNLOCK TABLES";
		mysql_query($unlockScrapingSourcesTable) 
					or die('No ha sido posible desbloquear tablas: ' . mysql_error());
							
		$addSourceToFuente = "INSERT INTO
					  fuente (id, fuente)
					  VALUES ($id, '$sourceName')";	
		$result	 = 	mysql_query($addSourceToFuente) 
					or die('No ha sido posible insertar en tabla de fuentes: ' . mysql_error());

		// eventually, this will return the last "fail"				
		return $result;
	}
	
	
	public static function getSourcesAndURLs() {
		$scrapingSources = 
		"SELECT source_url, source_name
		FROM scraping_source";
		
		$result	 = 	mysql_query($scrapingSources) 
					or die('Consulta fallida: ' . mysql_error());
		
		return $result;
	}
	
		
	// receives a list of ids; then set all ids in encuentro_temporal with status = 2
	// status = 1 (visible)
	// status = 2 (invisible, marked as not eligible)
	public static function setScrapedDataAsNotEligible($scrapedIDsArray) {
		
		foreach($scrapedIDsArray as $tempId) {
			$updateSQLStatement =
			"UPDATE encuentro_temporal 
			SET status = 2 
			WHERE id = $tempId";
			
			mysql_query($updateSQLStatement)
			or die('Consulta fallida: ' . mysql_error());
		}
		
		unset($scrapedIDsArray);
		
	}
	
}

?>
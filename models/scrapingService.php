<?php
// this class provides some services (TS pattern) for scraping operations

class ScrapingService {
	
	public static function addScrapingSource($sourceName, $sourceURL, $hasScraper) {
		$addScrapeSource = "INSERT INTO 
							scraping_source(source_name, source_url, has_scraper) 
							VALUES ('$sourceName', '$sourceURL', $hasScraper)";
		
		$result	 = 	mysql_query($addScrapeSource) 
					or die('Consulta fallida: ' . mysql_error());
		
		return $result;
		
	}
	
	
	public static function getSourcesAndId() {
		$encounterSource = 
		"SELECT id, fuente
		FROM fuente 
		ORDER BY fuente";
		
		$result	 = 	mysql_query($encounterSource) 
					or die('Consulta fallida: ' . mysql_error());
		
		$encounterSource = array();
		
		while ($line = mysql_fetch_array($result, MYSQL_NUM)) {
			$encounterSource = array_merge($encounterSource, array($line[0] => $line[1]));
		}
		
		// return the array containing the values for encounter types
		return $encounterSource;
	}
	
}

?>
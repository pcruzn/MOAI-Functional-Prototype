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
		
		return $result;
	}
	
}

?>
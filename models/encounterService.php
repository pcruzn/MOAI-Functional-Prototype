<?php
// this class provides some services (TS pattern) for encounters
// as an example, getting all encounter types
class EncounterService {
	
	public static function getEncounterSources() {
		$encounterSources = 
		"SELECT fuente 
		FROM fuente 
		GROUP BY fuente";
		
		$result	 = 	mysql_query($encounter) 
					or die('Consulta fallida: ' . mysql_error());
		
		$encounterTypes = array();
		
		while ($line = mysql_fetch_array($result, MYSQL_NUM)) {
			array_push($encounterTypes, $line[0]);
		}
		
		return $encounterTypes;
	}
	
	// this returns a mysql descriptor with all encounter sources from table 'fuente' and associated ids
	public static function getEncounterSourcesAndId() {
		$encounterSources = 
		"SELECT id, fuente
		FROM fuente 
		ORDER BY fuente";
		
		$result	 = 	mysql_query($encounterSources) 
					or die('Consulta fallida: ' . mysql_error());
		
		return $result;
	}
	

	// returns all encounter types
	public static function getEncounterTypes() {
		// query to select all encounter types
		$encounterTypes = 
		"SELECT tipo_encuentro 
		FROM tipo_encuentro 
		GROUP BY tipo_encuentro";
		
		$result	 = 	mysql_query($encounterTypes) 
					or die('Consulta fallida: ' . mysql_error());
		
		$encounterTypes = array();
		
		while ($line = mysql_fetch_array($result, MYSQL_NUM)) {
			array_push($encounterTypes, $line[0]);
		}
		
		// return the array containing the values for encounter types
		return $encounterTypes;
	}
	
	public static function getEncounterTypesAndId() {
		$encounterTypes = 
		"SELECT id, tipo_encuentro 
		FROM tipo_encuentro 
		ORDER BY tipo_encuentro";
		
		$result	 = 	mysql_query($encounterTypes) 
					or die('Consulta fallida: ' . mysql_error());
		
		return $result;
	}
	
	
	public static function getEncounterTypesCount($keyword=NULL, $type=NULL, $source=NULL) {
		// query to select all encounter types
		$sql =
		"SELECT tipo_encuentro.tipo_encuentro, COUNT(*) 
		FROM encuentro, tipo_encuentro 
		WHERE encuentro.tipo_encuentro = tipo_encuentro.id";

		if ($source) {
			$sql .= " AND encuentro.fuente = '$source'";
		}
		if($keyword){
			$sql .= " AND encuentro.descripcion LIKE '%$keyword%'";
		}
		if($type)
			$sql .= " AND encuentro.tipo_encuentro = $type";
		$sql .= " GROUP BY tipo_encuentro.tipo_encuentro";
		$sql .= " ORDER BY tipo_encuentro.tipo_encuentro";

		$result	 = 	mysql_query($sql)
					or die('Consulta fallida: ' . mysql_error());
		
		$encounterTypesCount = array();
		
		while ($line = mysql_fetch_array($result, MYSQL_NUM)) {
			$encounterTypesCount = array_merge($encounterTypesCount, array($line[0] => $line[1]));
		}
		
		// return the array containing the values for encounter types
		return $encounterTypesCount;
	}
	
	public static function getEncounterHoursCount($keyword=NULL, $type=NULL, $source=NULL) {
		// query to select all encounter types
		$sql =
		"SELECT hora.hora, COUNT(*) 
		FROM encuentro, hora 
		WHERE encuentro.hora = hora.id";

		if ($source) {
			$sql .= " AND encuentro.fuente = '$source'";
		}
		if($keyword){
			$sql .= " AND encuentro.descripcion LIKE '%$keyword%'";
		}
		if($type)
			$sql .= " AND encuentro.tipo_encuentro = $type";

		$sql .= " GROUP BY hora.hora 
		ORDER BY hora.hora";
		
		$result	 = 	mysql_query($sql)
					or die('Consulta fallida: ' . mysql_error());
		
		$encounterHoursCount = array();
		
		while ($line = mysql_fetch_array($result, MYSQL_NUM)) {
			$encounterHoursCount = array_merge($encounterHoursCount, array($line[0] => $line[1]));
		}
		
		// return the array containing the values for encounter types
		return $encounterHoursCount;
	}
	
	public static function getEncounterDatesCount($keyword=NULL, $type=NULL, $source=NULL) {
		// query to select all encounter types
		$sql =
		"SELECT encuentro.fecha, COUNT(*) 
		FROM encuentro 
		WHERE 1 = 1";

		if ($source) {
			$sql .= " AND encuentro.fuente = '$source'";
		}
		if($keyword){
			$sql .= " AND encuentro.descripcion LIKE '%$keyword%'";
		}
		if($type)
			$sql .= " AND encuentro.tipo_encuentro = $type";

		$sql.=" GROUP BY encuentro.fecha";
		
		$result	 = 	mysql_query($sql)
					or die('Consulta fallida: ' . mysql_error());
		
		$encounterDatesCount = array();
		
		while ($line = mysql_fetch_array($result, MYSQL_NUM)) {
			$encounterDatesCount = array_merge($encounterDatesCount, array($line[0] => $line[1]));
		}
		
		// return the array containing the values for encounter types
		return $encounterDatesCount;
	}
	
	public static function getEncounterLocalizationAndId() {
		$encounterLocalization = 
		"SELECT id, localizacion_administrativa 
		FROM localizacion_administrativa 
		ORDER BY localizacion_administrativa";
		
		$result	 = 	mysql_query($encounterLocalization) 
					or die('Consulta fallida: ' . mysql_error());
		
		return $result;
	}
	
	
	public static function getEncounterLocalizationCount($keyword=NULL, $type=NULL, $source=NULL) {
		// query to select all encounter types
		$sql =
		"SELECT localizacion_administrativa.localizacion_administrativa, COUNT(*) 
		FROM encuentro, localizacion_administrativa
		WHERE localizacion_administrativa.id = encuentro.localizacion_administrativa 
		AND localizacion_administrativa.localizacion_administrativa IS NOT NULL";

		if ($source) {
			$sql .= " AND encuentro.fuente = '$source'";
		}
		if($keyword){
			$sql .= " AND encuentro.descripcion LIKE '%$keyword%'";
		}
		if($type)
			$sql .= " AND encuentro.tipo_encuentro = $type";

		$sql .= " GROUP BY encuentro.localizacion_administrativa";
		
		$result	 = 	mysql_query($sql)
					or die('Consulta fallida: ' . mysql_error());
		
		$encounterLocalizationCount = array();
		
		while ($line = mysql_fetch_array($result, MYSQL_NUM)) {
			$encounterLocalizationCount = array_merge($encounterLocalizationCount, array($line[0] => $line[1]));
		}
		
		// return the array containing the values for encounter types
		return $encounterLocalizationCount;
	}

	public static function getEncounterCount($keyword=NULL, $type=NULL, $source=NULL) {
		// query to select all encounter types
		$sql =
			"SELECT COUNT(*) 
		FROM encuentro WHERE 1 = 1";

		if ($source) {
			$sql .= " AND encuentro.fuente = '$source'";
		}
		if($keyword){
			$sql .= " AND encuentro.descripcion LIKE '%$keyword%'";
		}
		if($type)
			$sql .= " AND encuentro.tipo_encuentro = $type";

		$result	 = 	mysql_query($sql)
		or die('Consulta fallida: ' . mysql_error());

		$encounterLocalizationCount = array();

		$encounterCount = 0;
		if ($line = mysql_fetch_array($result, MYSQL_NUM)) {
			$encounterCount = $line[0];
		}

		// return the array containing the values for encounter types
		return $encounterCount;
	}

	public static function getEncounterMicroLocalizationAndId() {
		$encounterMicroLocalization = 
		"SELECT id, microlocalizacion 
		FROM microlocalizacion 
		ORDER BY microlocalizacion";
		
		$result	 = 	mysql_query($encounterMicroLocalization) 
					or die('Consulta fallida: ' . mysql_error());
		
		return $result;
	}
	

	public static function getEncounterMicroLocalizationCount($keyword=NULL, $type=NULL, $source=NULL) {
		// query to select all encounter types
		$sql =
		"SELECT microlocalizacion.microlocalizacion, COUNT(*) 
		FROM encuentro, microlocalizacion
		WHERE microlocalizacion.id = encuentro.microlocalizacion 
		AND microlocalizacion.microlocalizacion IS NOT NULL";

		if ($source) {
			$sql .= " AND encuentro.fuente = '$source'";
		}
		if($keyword){
			$sql .= " AND encuentro.descripcion LIKE '%$keyword%'";
		}
		if($type)
			$sql .= " AND encuentro.tipo_encuentro = $type";

		$sql .= " GROUP BY encuentro.microlocalizacion";
		
		$result	 = 	mysql_query($sql)
					or die('Consulta fallida: ' . mysql_error());
		
		$encounterLocalizationCount = array();
		
		while ($line = mysql_fetch_array($result, MYSQL_NUM)) {
			$encounterLocalizationCount = array_merge($encounterLocalizationCount, array($line[0] => $line[1]));
		}
		
		// return the array containing the values for encounter types
		return $encounterLocalizationCount;
	}
	
	
	public static function getEncounterDurationAndId() {
		$encounterDuration = 
		"SELECT id, duracion
		FROM duracion 
		ORDER BY duracion";
		
		$result	 = 	mysql_query($encounterDuration) 
					or die('Consulta fallida: ' . mysql_error());
		
		return $result;
	}
	
	public static function getEncounterHourAndId() {
		$encounterHourAndId = 
		"SELECT id, hora
		FROM hora 
		ORDER BY hora";
		
		$result	 = 	mysql_query($encounterHourAndId) 
					or die('Consulta fallida: ' . mysql_error());
		
		return $result;
	}
	
	
	public static function getTemporaryEncounters($source) {
		// query to select all encounter types
		$temporaryEncounters = 
		"SELECT descripcion, fecha_obtencion , fuente
		FROM encuentro_temporal 
		WHERE fuente = '$source' 
		ORDER BY fecha_obtencion DESC";
		
		$result	 = 	mysql_query($temporaryEncounters) 
					or die('Consulta fallida: ' . mysql_error());
		
		// return mysql result descriptor
		return $result;
	}
	
	public static function getAllTemporaryEncounters() {
		// query to select all encounter types
		$temporaryEncounters = 
		"SELECT id, descripcion, fecha_obtencion, hora_obtencion, fuente, url
		FROM encuentro_temporal 
		ORDER BY fuente ASC";
		
		$result	 = 	mysql_query($temporaryEncounters) 
					or die('Consulta fallida: ' . mysql_error());
		
		// return mysql result descriptor
		return $result;
	}

	public function getAllAvailableTemporaryEncounters() {
		// query to select all encounter types
		$temporaryEncounters =
			"SELECT id, descripcion, fecha_obtencion, hora_obtencion, fuente, url
		FROM encuentro_temporal WHERE status = 1
		ORDER BY fuente ASC";

		$result	 = 	mysql_query($temporaryEncounters)
		or die('Consulta fallida: ' . mysql_error());

		// return mysql result descriptor
		return $result;
	}

	public static function filterTemporaryEncounters($status=NULL, $keyword=NULL, $fuente=NULL, $from=NULL, $to=NULL) {
		$sql = "SELECT id, descripcion, fecha_obtencion, hora_obtencion, fuente, url FROM encuentro_temporal WHERE 1 = 1";
		if ($fuente) {
			$sql .= " AND fuente = '$fuente'";
		}
		if ($from) {
			$sql .= " AND fecha_obtencion >= STR_TO_DATE('$from','%d/%m/%Y')";
		}
		if ($to) {
			$sql .= " AND fecha_obtencion <= STR_TO_DATE('$to','%d/%m/%Y')";
		}
		if($keyword){
			$sql .= " AND descripcion LIKE '%$keyword%'";
		}
		if($status)
			$sql .= " AND status = $status";

		$result	 = 	mysql_query($sql)
		or die('Consulta fallida: ' . mysql_error());

		// return mysql result descriptor
		return $result;
	}
	
	// returns a descriptor containing 'metadata' for temporary encounters
	// and with status = 1 (i.e., eligible)
	public static function getAllEligibleTemporaryEncounters() {
		$temporaryEligibleEncounters = 
		"SELECT id, descripcion, fecha_obtencion, hora_obtencion, fuente
		FROM encuentro_temporal 
		WHERE status = 3 
		ORDER BY fuente ASC";
		
		$result	 = 	mysql_query($temporaryEligibleEncounters) 
					or die('Consulta fallida: ' . mysql_error());
		
		// return mysql result descriptor
		return $result;
	}
	
	// returns a descriptor containing 'metadata' for temporary encounters
	// and with status = 2 (i.e., NOT eligible)
	public static function getAllNOTEligibleTemporaryEncounters() {
		$temporaryNOTEligibleEncounters = 
		"SELECT id, descripcion, fecha_obtencion, hora_obtencion, fuente
		FROM encuentro_temporal 
		WHERE status = 2 
		ORDER BY fuente ASC";
		
		$result	 = 	mysql_query($temporaryNOTEligibleEncounters) 
					or die('Consulta fallida: ' . mysql_error());
		
		// return mysql result descriptor
		return $result;
	}
	
	
	public static function getTemporaryEncounterById($id) {
		$temporaryEncounter = 
		"SELECT descripcion, fecha_obtencion, hora_obtencion, fuente
		FROM encuentro_temporal 
		WHERE id = $id";
		
		$result	 = 	mysql_query($temporaryEncounter) 
					or die('Consulta fallida: ' . mysql_error());
		
		// return mysql result descriptor
		return $result;
	}
	
	public static function deleteAllTemporaryEncounters() {
		// query to delete all temporary encounters
		$temporaryEncounters = 
		"DELETE FROM encuentro_temporal";
		
		$result	 = 	mysql_query($temporaryEncounters) 
					or die('Consulta fallida: ' . mysql_error());
		
		// return mysql result descriptor
		return $result;
	}
	
	public static function deleteTemporaryEncounterById($id) {
		// query to delete all temporary encounters
		$temporaryEncounters = 
		"DELETE FROM encuentro_temporal WHERE id = $id";
		
		$result	 = 	mysql_query($temporaryEncounters) 
					or die('Consulta fallida: ' . mysql_error());
		
		// return mysql result descriptor
		return $result;
	}
	
	
	public static function storeEncounter(
											$source,
											$description,
											$date,
											$time,
											$duration,
											$localization,
											$microlocalization,
											$encounterType
										) {
		
		$addEncounter = "INSERT INTO encuentro(fuente, descripcion, fecha, hora, duracion, localizacion_administrativa, microlocalizacion, tipo_encuentro) VALUES ($source, '$description', '$date', $time, $duration, $localization, $microlocalization, $encounterType)";
		
		echo $addEncounter;
		
		$result	 = 	mysql_query($addEncounter) 
					or die('Consulta fallida: ' . mysql_error());
		
		return $result;
		
	}
	
	
	
}

?>
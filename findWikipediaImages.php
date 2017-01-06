#!/usr/bin/php
<?php
	set_time_limit(0);
	error_reporting(E_ALL);
	
	
	/*** db.inc ***/
	try {
	$mysqli = new mysqli("localhost", "jjenne", "Tortuga01", "scientific");
	} catch (Exception $ex) {
		echo $ex->getMessage();
		exit();
	}
	
	
	function db_query($sql) {
		global $mysqli;
		return $mysqli->query($sql);
	}
	
	function db_fetch_assoc($result) {
		if ($result === FALSE)
			return FALSE;
		return $result->fetch_assoc();
	}
	
	function db_get_insert_id() {
		global $mysqli;
		return $mysqli->insert_id;
	}
	
	function db_free($result) {
		$result->free();
	}
	/*** end ***/
	
	
	$num = 20;
	$offset = 0;
	//$offset = 2000;
	while ($offset <= 643596) {
	//while ($offset < 1000) {
		$all_species = array();
		$sql = "SELECT tsn, complete_name
			FROM taxonomic_units 
			WHERE rank_id>='220' AND tsn NOT IN
			(SELECT DISTINCT parent_tsn FROM taxonomic_units)
			ORDER BY tsn LIMIT $offset, $num";
		$result = db_query($sql);
		while ($row = db_fetch_assoc($result)) {
			$all_species[] = $row;
		}

		for ($i=0; $i<count($all_species); $i++) {
			$complete_name = $all_species[$i]['complete_name'];
			$parts = explode(' ', $complete_name);
			$parts = array_unique($parts);
			$underscored_name = implode('_', $parts);
			
			//echo $underscored_name . ' - ';

			$c = curl_init();
			curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($c, CURLOPT_URL, "http://en.wikipedia.org/wiki/$underscored_name");
			$html = curl_exec($c);
			curl_close($c);

			$failstr = "Wikipedia does not have an article with this exact name";
			if (strpos($html, $failstr) === FALSE) {
				$tsn = $all_species[$i]['tsn'];

				$sql = "INSERT INTO tsn_links
					(tsn, linkUrl, linkType, status) VALUES('$tsn', 'http://en.wikipedia.org/wiki/$underscored_name', 'wikipedia', 'A')
					";
				db_query($sql);

				preg_match_all("/<img.*src\s*=\s*['\"](.*\.jpg)['\"]/Umi", $html, $matches);

				if (!empty($matches)) {
					for ($m = 0; $m < count($matches[1]); $m++) {
						if (!empty($matches[1])) {
							$img_url = $matches[1][$m];
							//echo $img_url;
							//exit();

							$sql = "INSERT INTO tsn_images
								(tsn, imageUrl, status) VALUES('$tsn', '$img_url', 'P')
								";
							db_query($sql);
						}
					}
				}
			}
			//echo "<br/>";
		}
		
		
		$offset += $num;
		
		unset($all_species);
		unset($result);
		unset($html);
		unset($matches);
	}
	
	echo 'done';
?>

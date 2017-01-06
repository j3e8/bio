<?php
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
?>

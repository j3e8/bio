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
	


	// the array that contains it all
	$all_species = array();

	// get root information
	$root_tsn = $_GET['tsn'];
	//$tsn = '174442';
	$sql = "SELECT complete_name, imageUrl
		FROM taxonomic_units AS t
		LEFT JOIN tsn_images AS ti ON t.tsn=ti.tsn
		WHERE t.tsn='$root_tsn'";
	$result = db_query($sql);
	if ($row = db_fetch_assoc($result)) {
		$all_species['tsn'] = $root_tsn;
		$all_species['name'] = $row['complete_name'];
		$all_species['imageUrl'] = $row['imageUrl'];
	}


	function populateChildren(&$node) {
		// get all children
		$sql = "SELECT t.tsn, t.complete_name, ti.imageUrl
			FROM taxonomic_units AS t
			LEFT JOIN tsn_images AS ti ON t.tsn=ti.tsn
			WHERE t.parent_tsn='{$node['tsn']}'
			ORDER BY t.tsn";
		$result = db_query($sql);
		while ($row = db_fetch_assoc($result)) {
			$node['children'][] = array('tsn' => $row['tsn'], 'name' => $row['complete_name'], 'imageUrl' => $row['imageUrl']);
		}
		if (!empty($node['children'])) {
			for ($c=0; $c<count($node['children']); $c++) {
				populateChildren($node['children'][$c]);
			}
		}
	}
	populateChildren($all_species);

	header('Content-type: text/plain');
	header('Content-disposition: attachment; filename='.$root_tsn.'.js');
	echo "var bio_tree = ";
	echo json_encode($all_species);
	echo ";";

	unset($all_species);


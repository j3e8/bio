<?php
	set_time_limit(0);
	error_reporting(E_ALL);
	
	include_once('lib/db.inc');
	
	$sql = "DROP TABLE taxonomic_units";
	db_query($sql);
	
	echo 'done';
?>

<?php
	set_time_limit(0);
	error_reporting(E_ALL);
	
	include_once('lib/db.inc');
	
	//$sql = "CREATE FULLTEXT INDEX vernacular_fulltext_idx ON vernaculars (vernacular_name)";
	$sql = "DROP INDEX hierarchy_string ON hierarchy";
	//$sql = "CREATE INDEX tsn_idx ON vernaculars (tsn)";
	//$sql = "ALTER TABLE hierarchy DROP PRIMARY KEY, ADD PRIMARY KEY (tsn)";
	
	/*$sql = "SELECT COUNT(complete_name) AS num
		FROM taxonomic_units 
		WHERE rank_id>='220' AND tsn NOT IN
		(SELECT DISTINCT parent_tsn FROM taxonomic_units)";*/
	//echo "$sql<br/><br/>done";
	//db_query($sql);
	$result = db_query($sql);
	
	//$row = db_fetch_assoc($result);
	//echo $row['num'];
	echo 'done';
?>

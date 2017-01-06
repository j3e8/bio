<?php

	$search_term = '';

	if (isset($_REQUEST['q'])) {
		$search_term = $_REQUEST['q'];
		$q = addslashes($_REQUEST['q']);
		$search_results = array();
		
		$sql = "SELECT t.tsn, t.complete_name, t.parent_tsn, t.rank_id, k.kingdom_name, v.vernacular_name 
			FROM taxonomic_units AS t 
			INNER JOIN kingdoms AS k ON t.kingdom_id=k.kingdom_id 
			INNER JOIN (
				SELECT tsn FROM vernaculars 
					WHERE MATCH(vernacular_name) AGAINST('$q') 
				UNION 
				SELECT tsn FROM taxonomic_units 
					WHERE MATCH(complete_name) AGAINST('$q')
			) AS s ON t.tsn=s.tsn 
			LEFT JOIN vernaculars AS v ON t.tsn=v.tsn and (v.language='English' or v.language='unspecified')
			ORDER BY t.parent_tsn, t.tsn, vernacular_name, complete_name
				";
		$results = db_query($sql);
		while ($row = db_fetch_assoc($results)) {
			$search_results[] = $row;
		}
	}
?>

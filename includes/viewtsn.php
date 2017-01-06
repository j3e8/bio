<?php

	if (!isset($_REQUEST['tsn']) || !is_numeric($_REQUEST['tsn']))
		$tsn = '';
	else
		$tsn = $_REQUEST['tsn'];
	
	// get information about this node
	$sql = "SELECT DISTINCT t.tsn, t.parent_tsn, complete_name, vernacular_name, 
		t.rank_id, rank_name, h.childrencount, tu.backgroundColor, tu.color,
		tl.linkUrl, tl.linkType, ti.imageUrl
		FROM taxonomic_units AS t 
		INNER JOIN taxon_unit_types AS tu ON t.kingdom_id=tu.kingdom_id AND t.rank_id=tu.rank_id
		INNER JOIN hierarchy AS h ON t.tsn=h.tsn
		LEFT JOIN vernaculars AS v ON t.tsn=v.tsn AND v.language='English'
		LEFT JOIN tsn_links AS tl ON t.tsn=tl.tsn
		LEFT JOIN tsn_images AS ti ON t.tsn=ti.tsn
		WHERE t.tsn='$tsn'
		";
	$result = db_query($sql);
	$first = true;
	$common_names = '';
	while ($row = db_fetch_assoc($result)) {
		if ($first)
			$tsn_info = $row;
		if (isset($row['vernacular_name']) && $row['vernacular_name'] != '') {
			if (strlen($common_names) > 0)
				$common_names .= ', ';
			$common_names .= $row['vernacular_name'];
		}
		$first = false;
	}
	
	// get lineage
	$parent_tsn_arr = array();
	if ($tsn != '') {
		$parent_tsn = $tsn_info['parent_tsn'];
		$tsn_rank = $tsn_info['rank_id'];
		while ($tsn_rank > 10) {
			$sql = "SELECT DISTINCT t.tsn, t.parent_tsn, complete_name, t.rank_id, tu.rank_name, h.childrencount, tu.backgroundColor, tu.color
				FROM taxonomic_units AS t 
				INNER JOIN taxon_unit_types AS tu ON t.kingdom_id=tu.kingdom_id AND t.rank_id=tu.rank_id
				INNER JOIN hierarchy AS h ON t.tsn=h.tsn
				WHERE t.tsn='$parent_tsn'
				";
			$result = db_query($sql);
			$row = db_fetch_assoc($result);
			$parent_tsn_arr[] = $row;
			$parent_tsn = $row['parent_tsn'];
			$tsn_rank = $row['rank_id'];
		}
	}
	
	// get children
	$children_tsn_arr = array();
	if ($tsn == '')
		$sql = "SELECT * FROM taxonomic_units where rank_id=10 and tsn<>0";
	else
		$sql = "SELECT DISTINCT t.tsn, t.parent_tsn, complete_name, vernacular_name, t.rank_id, tu.rank_name, h.childrencount, tu.backgroundColor, tu.color
			FROM taxonomic_units AS t 
			INNER JOIN taxon_unit_types AS tu ON t.kingdom_id=tu.kingdom_id AND t.rank_id=tu.rank_id
			INNER JOIN hierarchy AS h ON t.tsn=h.tsn
			LEFT JOIN vernaculars AS v ON t.tsn=v.tsn AND v.language='English'
			WHERE t.parent_tsn='$tsn'
			";
	$result = db_query($sql);
	$last_tsn = '';
	while ($row = db_fetch_assoc($result)) {
		if ($row['tsn'] == $last_tsn) {
			if ($row['vernacular_name'] != '') {
				if ($children_tsn_arr[count($children_tsn_arr)-1]['vernacular_name'] != '')
					$children_tsn_arr[count($children_tsn_arr)-1]['vernacular_name'] .= ', ';
				$children_tsn_arr[count($children_tsn_arr)-1]['vernacular_name'] .= $row['vernacular_name'];
			}
		}
		else
			$children_tsn_arr[] = $row;
		$last_tsn = $row['tsn'];
	}
	
	
?>

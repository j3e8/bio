<?php
	class Bird {
		static function getUnknownBird() {
			$bird = array();

			$hier = '202423-914154-914156-158852-331030-914179-914181-174371';

			$sql = "SELECT t.tsn, complete_name, RAND() as r
				FROM taxonomic_units AS t
				INNER JOIN hierarchy AS h ON t.tsn=h.tsn
				WHERE h.hierarchy_string LIKE '$hier-%'
				AND t.rank_id>=220
				AND h.ChildrenCount=0
				ORDER BY r
				LIMIT 1
				";
			$result = db_query($sql);
			if ($row = db_fetch_assoc($result)) {
				$bird = $row;

				// get images
				$sql = "SELECT imageUrl FROM tsn_images
					WHERE tsn={$bird['tsn']}";
				$result = db_query($sql);
				while ($row = db_fetch_assoc($result)) {
					$bird['images'][] = $row;
				}

				// get common names
				$sql = "SELECT vernacular_name FROM vernaculars
					WHERE tsn={$bird['tsn']}
					AND (language='English' OR language='unspecified')
					";
				$result = db_query($sql);
				while ($row = db_fetch_assoc($result)) {
					$bird['names'][] = $row;
				}
			}

			return $bird;
		}

		static function saveBirdData() {
		
		}
	}


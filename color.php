<?php

	$r = 36;
	$g = 63;
	$b = 130;
	
	$r_inc = (255 - $r) / 18;
	$g_inc = (255 - $g) / 18;
	$b_inc = (255 - $b) / 18;
	
	do {
		echo dechex(round($r)) . dechex(round($g)) . dechex(round($b)) . "<br/>";
		$r += $r_inc;
		if ($r > 255) $r = 255;
		$g += $g_inc;
		if ($g > 255) $g = 255;
		$b += $b_inc;
		if ($b > 255) $b = 255;
	} while ($r < 255 && $g < 255 && $b < 255);
?>

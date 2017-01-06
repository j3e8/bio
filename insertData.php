<?php
	set_time_limit(0);
	error_reporting(E_ALL);
	
	include_once('lib/db.inc');
	
	
	if (isset($_FILES['thefile'])) {
		//$str = file_get_contents($_FILES['thefile']['tmp_name']);
		
		$i = 0;
		$fh = fopen($_FILES['thefile']['tmp_name'], 'r');
		while ($line = fgets($fh)) {
			$fields = explode('|', $line);
			$sql = "INSERT INTO hierarchy
				VALUES(";
			
			$first = true;
			foreach ($fields as $value) {
				$value = trim($value);
				if ($first) {
					$sql .= "'$value'";
					$first = false;
				}
				else
					$sql .= ",'$value'";
			}
			
			$sql .= ")";
			db_query($sql);
			
			$i++;
			
			if ($i % 1000 == 0) {
				echo '.';
				flush();
			}
		}
		fclose($fh);
		
		echo 'done';
		exit();
	}
	
	
?>

<html><head><title>upload data</title></head>
	<body>
		<form name="uploadForm" action="insertData.php" method="post" enctype="multipart/form-data">
			<input type="file" name="thefile" />
			<input type="submit" name="submitButton" value="submit" />
		</form>
	</body>
</html>
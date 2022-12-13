<!DOCTYPE html>
<html lang="it-IT">
	<head>
		<meta charset="utf-8">
		<title>Tavola pitagorica</title>
		<style>
			table, td{
				border: 1px solid gray;
			}
		</style>
	<body>
		<h1>Tavola Pitagorica</h1>

		<table>
			<?php
				for ($i = 1; $i <= 10; $i++) {      	
					echo "<tr>";
					for ($j = 1; $j <= 10; $j++) {
						$r = $i*$j;
						echo "<td>".$r."</td>";
					}
					echo "</tr>";
				}
			?>
		</table>
	</body>
</html>
<table width = '100%' class = <?php echo $table_class; ?>>
	<tr><th>服id</th><th>类型</th><th>命令</th><th>参数</th></tr>
	<?php
		if ($_SESSION[DBIndex] == 0) {
			//foreach ($serverList as $key => $value) {
				//GetGMCommandInfo($key);
			//}
			// 什么也不做
		}
		else {
			GetGMCommandInfo($_SESSION[DBIndex]);
		}

		function GetGMCommandInfo($sIndex) {
			$conn = GetDBByIndex($sIndex);
			$serverId = GetServerId($_SESSION[DBIndex]);
			if ($conn != null) {
				$sql = "select * from gmcommand where worldid = '$serverId'";
				$query = mysqli_query($conn, $sql);
				while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
					echo "<tr><th>$row[worldid]</th><th>$row[type]</th><th>$row[command]</th><th>$row[param]</th></tr>";
				}
				mysqli_free_result($query);
			}
			mysqli_close($conn);
		}
	?>
</table>
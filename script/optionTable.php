<?php
	echo "<table width = '100%' class = $option_table>
		<tr><th>操作者</th><th>操作内容</th><th>操作服</th><th>玩家信息</th><th>时间</th></tr>";
		if ($conn != null) {
			// 只查找发放物品的信息
			//$sql = "select * from option_record where `option` like '发放物品-%' order by id desc";
			//$sql = "select * from option_record order by id desc";
			$query = mysqli_query($conn, $sql);
			while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
				echo "<tr><th>$row[username]</th><th>$row[option]</th><th>$row[optionserver]</th><th>$row[player]</th><th>$row[time]</th></tr>";
			}
			mysqli_free_result($query);
		}
	echo "</table>";
?>
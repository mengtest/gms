<?php
	$Title = "这里是道具购买页";
	require_once("../html/header.html");
	echo "<div class = 'shade_div'></div>";
	require_once("../config/menu.php");

	// 检测登陆状态
	require_once("../script/check.php");
	$checkVal = JurisdictionCheck(basename($_SERVER["PHP_SELF"]), $_SESSION[uid]);
	if ($checkVal != 0) {
		ThrowError($checkVal);
	}

	require_once("../config/DBList.php");
	require_once("../config/logCfg.php");
	require_once("../script/selectserver.php");

	echo "<table width = '100%' class = 'item_ra_table'>
		<tr><th>类型名称</th><th>道具名称</th><th>购买数量</th><th>消耗货币</th></tr>";

	if ($_POST[submitItemAllQuqry]) {
		$conn = GetDBByIndex($_SESSION[DBIndex]);
		$conn_log = GetLogDBByIndex($_SESSION[DBIndex]);
		$serverId = GetServerId($_SESSION[DBIndex]);
		if ($conn == null || $conn_log == null || $_SESSION[DBIndex] <= 0 || $serverId <= 0) {
			alertMsg("请先选择服再操作");
		}
		else if ($_POST[start_time] == null || $_POST[end_time] == null) {
			alertMsg("请输入有效日期");
		}
		else {
			$startTime = strtotime($_POST[start_time]);
			$endTime = strtotime($_POST[end_time]) + (24 * 60 * 60);
			if ($startTime > $endTime) {
				alertMsg("开始时间不能比结束时间大");
			}
			else {
				// 记录信息
				$_SESSION[SIAQ_startTime] = $_POST[start_time];
				$_SESSION[SIAQ_endTime] = $_POST[end_time];
				$_SESSION[SIAQ_moneyType] = $_POST[money_type];
				$_SESSION[SIAQ_itemId] = $_POST[item_id];

				$sql = "select * from moneylog where moneytype = '$_POST[money_type]' and itemname != '' and ('$_POST[item_id]' = '' or itemid = '$_POST[item_id]')";
				$query = mysqli_query($conn_log, $sql);

				$result = array();
				while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
					$logType = $row[logtype];
					$moneyValue = $row[numbefore] - $row[numafter];
					if ($moneyValue <= 0) continue;
					$value = array(
						"moneyvalue" => $moneyValue,
						"itemname" => $row[itemname],
						"itemnum" => $row[itemnum],
						);

					if (!$result[$logType]) {
						// 新增
						$result[$logType] = $value;
					}
					else {
						// 叠加
						$result[$logType]["moneyvalue"] += $moneyValue;
						$result[$logType]["itemnum"] += $row[itemnum];
					}
				}

				$i = line_bg_s;
				foreach ($result as $type => $value) {
					$styleBG = ($i % line_bg_l == 0) ? "style='background-color:".line_bg_c.";'" : "";
					$i++;

					$Sourcr = GetLogTypeName($type);
					$itemName = $value["itemname"];
					$itemNum = $value["itemnum"];
					$moneyValue = $value["moneyvalue"];
					echo "<tr $styleBG align='center'><td>$Sourcr</td><td>$itemName</td><td>$itemNum</td><td>$moneyValue</td></tr>";
				}
			}
		}
	}

	echo "</table>";
?>

<div style = "position:fixed; top:26%; left:21%; ">
	<a href = "recordPerson">个人记录</a>&nbsp;
	道具购买统计&nbsp;
	<a href = "itemRecordSource">道具产出</a>&nbsp;
	<a href = "moneyRecord">货币统计</a>
</div>

<form action="" method="post" class = 'item_ra_form'>
 	开始时间：<input name="start_time" type="date" value="<?php echo $_SESSION[SIAQ_startTime] ?>" />
 	结束时间：<input name="end_time" type="date" value="<?php echo $_SESSION[SIAQ_endTime] ?>" />
 	货币类型：<select name="money_type">
 	<?php
 		foreach ($MoneyType as $type => $name) {
 			$select = $_SESSION[SIAQ_moneyType] == $type ? ' selected' : '';
			echo "<option value='$type' $select>$name</option>";
 		}
 	?>
 	</select>
 	道具ID：<input name="item_id" type="text" value="<?php echo $_SESSION[SIAQ_itemId] ?>" />
 	<input name="submitItemAllQuqry" type="submit" value="查询" />
</form>

<hr class = 'item_ra_hr' />

<?php
	require_once("../html/bottom.html");
?>
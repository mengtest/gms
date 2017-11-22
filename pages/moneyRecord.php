<?php
	$Title = "这里是个人记录页";
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

	echo "<table width = '100%' class = 'money_table'>
		<tr><th>类型</th><th>类型名称</th><th>消耗数量</th></tr>";

	if ($_POST[submitMoneyQuqry]) {
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
				$_SESSION[SMQ_startTime] = $_POST[start_time];
				$_SESSION[SMQ_endTime] = $_POST[end_time];
				$_SESSION[SMQ_moneyType] = $_POST[money_type];

				$sql = "select * from moneylog where moneytype = '$_POST[money_type]'";
				$query = mysqli_query($conn_log, $sql);

				$result = array();
				while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
					$logType = $row[logtype];
					$moneyValue = $row[numbefore] - $row[numafter];
					if ($moneyValue <= 0) continue;

					if (!$result[$logType]) {
						// 新增
						$result[$logType] = $moneyValue;
					}
					else {
						// 叠加
						$result[$logType] += $moneyValue;
					}
				}

				$i = line_bg_s;
				foreach ($result as $type => $value) {
					$styleBG = ($i % line_bg_l == 0) ? "style='background-color:".line_bg_c.";'" : "";
					$i++;

					$Sourcr = GetLogTypeName($type);
					echo "<tr $styleBG align='center'><td>$type</td><td>$Sourcr</td><td>$value</td></tr>";
				}
			}
		}
	}

	echo "</table>";
?>

<div style = "position:fixed; top:26%; left:21%; ">
	<a href = "recordPerson">个人记录</a>&nbsp;
	<a href = "itemRecordAll">道具统计</a>&nbsp;
	<a href = "itemRecordSource">道具产出</a>&nbsp;
	货币统计
</div>

<form action="" method="post" class = 'money_form'>
 	开始时间：<input name="start_time" type="date" value="<?php echo $_SESSION[SMQ_startTime] ?>" />
 	结束时间：<input name="end_time" type="date" value="<?php echo $_SESSION[SMQ_endTime] ?>" />
 	货币类型：<select name="money_type">
 	<?php
 		foreach ($MoneyType as $type => $name) {
 			$select = $_SESSION[SMQ_moneyType] == $type ? ' selected' : '';
			echo "<option value='$type' $select>$name</option>";
 		}
 	?>
 	</select>
 	<input name="submitMoneyQuqry" type="submit" value="查询" />
</form>

<hr class = 'money_hr' />

<?php
	require_once("../html/bottom.html");
?>
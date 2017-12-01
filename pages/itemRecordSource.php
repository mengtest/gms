<?php
	$Title = "这里是道具产出页";
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

	echo "<table width = '100%' class = 'item_rs_table'>
		<tr><th>道具id</th><th>道具名称</th><th>数量</th><th>获取途径</th><th>时间</th></tr>";

	if ($_POST[submitItemSource]) {
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
				$_SESSION[SIS_startTime] = $_POST[start_time];
				$_SESSION[SIS_endTime] = $_POST[end_time];
				$_SESSION[SIS_item_id] = $_POST[item_id];

				$sql = "select * from itemlog where itemnum > 0 and ('$_POST[item_id]' = '' or itemid = '$_POST[item_id]')";
				if (count($ItemSourceTypeList) > 0) {
					$sql .= "and (";
					$bIsFirst = true;
					foreach ($ItemSourceTypeList as $key => $value) {
						if ($bIsFirst) {
							$sql .= "logtype = '$key'";
							$bIsFirst = false;
						}
						else {
							$sql .= " or logtype = '$key'";
						}
					}
					$sql .= ")";
				}

				$query = mysqli_query($conn_log, $sql);

				$i = line_bg_s;
				while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
					$styleBG = ($i % line_bg_l == 0) ? "style='background-color:".line_bg_c.";'" : "";
					$i++;

					$Sourcr = GetLogTypeName($row[logtype]);
					echo "<tr $styleBG align='center'><td>$row[itemid]</td><td>$row[itemname]</td><td>$row[itemnum]</td><td>$Sourcr</td><td>$row[logtm]</td></tr>";
				}
			}
		}
	}

	echo "</table>";
?>

<div style = "position:fixed; top:26%; left:21%;">
	<a href = "recordPerson">个人记录</a>&nbsp;
	<a href = "itemRecordAll">道具购买统计</a>&nbsp;
	道具产出&nbsp;
	<a href = "moneyRecord">货币统计</a>
</div>

<form action="" method="post" class = 'item_rs_form'>
 	开始时间：<input name="start_time" type="date" value="<?php echo $_SESSION[SIS_startTime] ?>" />
 	结束时间：<input name="end_time" type="date" value="<?php echo $_SESSION[SIS_endTime] ?>" />
 	道具ID：<input name="item_id" type="text" value="<?php echo $_SESSION[SIS_item_id] ?>" />
 	<input name="submitItemSource" type="submit" value="查询" />
</form>

<hr class = 'item_rs_hr' />

<?php
	require_once("../html/bottom.html");
?>
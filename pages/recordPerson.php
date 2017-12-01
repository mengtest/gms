<?php
	$Title = "这里是个人记录页";
	require_once("../html/header.html");
	echo "<div class = 'shade_div5'></div>";
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

	if ($_POST[submitItemQuqry]) {
		$conn = GetDBByIndex($_SESSION[DBIndex]);
		$conn_log = GetLogDBByIndex($_SESSION[DBIndex]);
		$serverId = GetServerId($_SESSION[DBIndex]);
		if ($conn == null || $conn_log == null || $_SESSION[DBIndex] <= 0 || $serverId <= 0) {
			alertMsg("请先选择服再操作");
		}
		else if ($_POST[start_time] == null || $_POST[end_time] == null) {
			alertMsg("请输入有效日期");
		}
		else if ($_POST[player_name] == null) {
			alertMsg("请输入要查询角色名称");
		}
		else {

			$startTime = strtotime($_POST[start_time]);
			$endTime = strtotime($_POST[end_time]) + (24 * 60 * 60);
			if ($startTime > $endTime) {
				alertMsg("开始时间不能比结束时间大");
			}
			else {
				// 记录信息
				$_SESSION[SIQ_startTime] = $_POST[start_time];
				$_SESSION[SIQ_endTime] = $_POST[end_time];
				$_SESSION[SIQ_playerName] = $_POST[player_name];
				$_SESSION[SIQ_qType] = $_POST[qType];

				$sql = "select * from charfulldata where charname = '$_POST[player_name]'";
				$query = mysqli_query($conn, $sql);
				if ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
					// 角色存在
					echo "<table width = '100%' class = 'item_r_table_p'>
					<tr><th>玩家名称</th><th>等级</th><th>职业</th><th>VIP</th><th>灵玉</th><th>元宝</th><th>银两</th><th>银票</th><th>经验</th><th>专用经验</th></tr>
					<tr style='background-color:".line_bg_c."'' align='center'><td>$row[charname]</td><td>$row[level]</td><td>$row[profession]</td><td>$row[nvipcost]</td><td>$row[moneytype_yuanbao]</td><td>$row[moneytype_yuanbao_bind]</td><td>$row[moneytype_coin]</td><td>$row[moneytype_yingliang_bind]</td><td>$row[exp]</td><td>$row[privateexp]</td></tr>
					</table>";

					echo "<table width = '100%' class = 'item_r_table'>
					<tr><th>类型</th><th>日志描述</th><th>时间</th></tr>";

						$sql_log = "select * from itemlog where guid = $row[guid] and unix_timestamp(logtm) >= $startTime and unix_timestamp(logtm) <= $endTime order by unix_timestamp(logtm) desc";
						$query_log = mysqli_query($conn_log, $sql_log);
						$i = line_bg_s;
						while ($row_log = mysqli_fetch_array($query_log, MYSQLI_ASSOC)) {
							if ($_SESSION[SIQ_qType]) {
								$qTypeArr = explode(",", $_SESSION[SIQ_qType]);
								$IsQueryType = false;
								for ($i = 0; $i < count($qTypeArr); $i++) { 
									if ($qTypeArr[$i] == $row_log[logtype]) {
										$IsQueryType = true;
										break;
									}
								}

								if (!$IsQueryType) {
									// 不是筛选的类型
									continue;
								}
							}

							$styleBG = ($i % line_bg_l == 0) ? "style='background-color:".line_bg_c.";'" : "";
							$i++;

							$Sourcr = GetLogTypeName($row_log[logtype]);
							$Describe = GetLogDescribe($row_log[logtype], $row_log[itemid], $row_log[itemnum], $row_log[itemname]);

							echo "<tr $styleBG align='center'><td>$Sourcr</td><td>$Describe</td><td>$row_log[logtm]</td></tr>";
						}

						$sql_log2 = "select * from moneylog where guid = $row[guid] and unix_timestamp(logtm) >= $startTime and unix_timestamp(logtm) <= $endTime order by unix_timestamp(logtm) desc";
						$query_log2 = mysqli_query($conn_log, $sql_log2);
						while ($row_log2 = mysqli_fetch_array($query_log2, MYSQLI_ASSOC)) {
							if ($_SESSION[SIQ_qType]) {
								$qTypeArr = explode(",", $_SESSION[SIQ_qType]);
								$IsQueryType = false;
								for ($i = 0; $i < count($qTypeArr); $i++) { 
									if ($qTypeArr[$i] == $row_log2[logtype]) {
										$IsQueryType = true;
										break;
									}
								}

								if (!$IsQueryType) {
									// 不是筛选的类型
									continue;
								}
							}

							$styleBG = ($i % line_bg_l == 0) ? "style='background-color:".line_bg_c.";'" : "";
							$i++;

							$Sourcr = GetLogTypeName($row_log2[logtype]);
							$moneyvalue = $row[numbefore] - $row[numafter];
							$Describe = GetLogDescribe($row_log2[logtype], $row_log2[itemid], $row_log2[itemnum], $row_log2[itemname], $row_log2[moneytype], $moneyvalue);

							echo "<tr $styleBG align='center'><td>$Sourcr</td><td>$Describe</td><td>$row_log2[logtm]</td></tr>";
						}

						$sql_log3 = "select * from commonlog where guid = $row[guid] and unix_timestamp(logtm) >= $startTime and unix_timestamp(logtm) <= $endTime order by unix_timestamp(logtm) desc";
						$query_log3 = mysqli_query($conn_log, $sql_log3);
						while ($row_log3 = mysqli_fetch_array($query_log3, MYSQLI_ASSOC)) {
							if ($_SESSION[SIQ_qType]) {
								$qTypeArr = explode(",", $_SESSION[SIQ_qType]);
								$IsQueryType = false;
								for ($i = 0; $i < count($qTypeArr); $i++) { 
									if ($qTypeArr[$i] == $row_log3[logtype]) {
										$IsQueryType = true;
										break;
									}
								}

								if (!$IsQueryType) {
									// 不是筛选的类型
									continue;
								}
							}

							$styleBG = ($i % line_bg_l == 0) ? "style='background-color:".line_bg_c.";'" : "";
							$i++;

							$Sourcr = GetLogTypeName($row_log3[logtype]);
							$Describe = GetLogDescribe($row_log3[logtype], $row_log3[intparam1], $row_log3[intparam2], $row_log3[intparam3], $row_log3[intparam4], $row_log3[intparam5], $row_log3[floatparam1], $row_log3[floatparam2], $row_log3[floatparam3], $row_log3[floatparam4], $row_log3[floatparam5], $row_log3[strparam1], $row_log3[strparam2], $row_log3[strparam3], $row_log3[strparam4], $row_log3[strparam5]);

							echo "<tr $styleBG align='center'><td>$Sourcr</td><td>$Describe</td><td>$row_log3[logtm]</td></tr>";
						}

					echo "</table>";
				}
			}
		}
	}
?>

<div style = "position:fixed; top:26%; left:21%; ">
	个人记录&nbsp;
	<a href = "itemRecordAll">道具购买统计</a>&nbsp;
	<a href = "itemRecordSource">道具产出</a>&nbsp;
	<a href = "moneyRecord">货币统计</a>
</div>

<form action="" method="post" class = 'item_r_form'>
 	开始时间：<input name="start_time" type="date" value="<?php echo $_SESSION[SIQ_startTime] ?>" />
 	结束时间：<input name="end_time" type="date" value="<?php echo $_SESSION[SIQ_endTime] ?>" />
 	角色名称：<input name="player_name" type="text" value="<?php echo $_SESSION[SIQ_playerName] ?>" />
 	筛选类型：<input name="qType" type="text" value="<?php echo $_SESSION[SIQ_qType] ?>" title="多个类型可用','隔开" />
 	<input name="submitItemQuqry" type="submit" value="查询" />
</form>

<hr class = 'item_r_hr' />

<?php
	require_once("../html/bottom.html");
?>
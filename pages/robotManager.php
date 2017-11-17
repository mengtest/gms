<?php
	$Title = "这里是机器人管理页";
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
	require_once("../script/selectserver.php");
	require_once("../script/optionrecord.php");
?>

<form action="" method="post" class = 'robot_form'>
 	场景ID：<input name="sceneId" type="text" /><br /><br /><br />
 	机器人数量：<input name="robotCount" type="text" /><br /><br /><br />
 	玩家少于：<input name="needPlayer" type="text" />人<br />
 	<font>(不填或填0代表无限制)</font><br /><br /><br />
 	插入时间：<input name="createTime" type="text" />秒<br />
 	<font>(不填或填0代表立即)</font><br /><br /><br />
 	删除时间：<input name="deleteTime" type="text" />秒<br />
 	<font>(不填或填0代表不删除)</font><br /><br />
 	<input name="submitRobot" type="submit" value="提交" />
</form>

<hr class = 'robot_hr' />

<?php
	$conn = GetDBByIndex(0);
	$conns = GetDBByIndex($_SESSION[DBIndex]);
	$serverId = GetServerId($_SESSION[DBIndex]);
	$now = time();

	function OnRobotOption($temp_conn, $temp_serverId, $type, $scene, $count, $player, $create, $delete) {
		if ($temp_conn != null && $temp_serverId > 0) {
			if ($type == 0) {
				$sqls = "insert into gmcommand(worldid, type, command, param) values('$temp_serverId', '7', '$type', '".$scene.",".$count.",".$player.",".$create.",".$delete."')";
			}
			else {
				$sqls = "insert into gmcommand(worldid, type, command) values('$temp_serverId', '7', '$type')";
			}
			if (mysqli_query($temp_conn, $sqls)) {
				return true;
			}
		}

		return false;
	}

	function SendAlertMsg($type, $scene, $count, $player, $create, $delete) {
		$optionName = ($type == 1 ? "删除机器人成功" : "添加机器人成功");

		$playerInfo = "不限制";
		if ($player > 0) {
			$playerInfo = $player;
		}

		$createTime = date("Y/m/d h:i:sa");
		if ($create > 0) {
			$createTime = date("Y/m/d h:i:sa", $create);
		}

		$deleteTime = "无";
		if ($delete > 0) {
			$deleteTime = date("Y/m/d h:i:sa", $delete);
		}

		alertMsg($optionName."\\n场景:".$scene."\\n数量:".$count."\\n玩家少于:".$playerInfo."\\n创建时间:".$createTime."\\n删除时间:".$deleteTime);
	}

	if($_POST[submitRobot]){
		if ($conn == null || $conns == null || $_SESSION[DBIndex] <= 0 || $serverId <= 0) {
			alertMsg("请先选择服再操作");
		}
		elseif ($_POST[sceneId] == null || $_POST[sceneId] <= 0) {
			alertMsg("请输入有效的场景ID");
		}
		elseif ($_POST[robotCount] == null || $_POST[robotCount] <= 0) {
			alertMsg("请输入有效的机器人数量");
		}
		else {
			$tNeedPlayer = 0;
			$tCreateTime = 0;
			$tDeleteTime = 0;
			if ($_POST[needPlayer] && $_POST[needPlayer] > 0) {
				$tNeedPlayer = $_POST[needPlayer];
			}

			if ($_POST[createTime] && $_POST[createTime] > 0) {
				$tCreateTime = $_POST[createTime] + $now;
			}

			if ($_POST[deleteTime] && $_POST[deleteTime] > 0) {
				$tDeleteTime = $_POST[deleteTime] + $now;
			}

			if (OnRobotOption($conns, $serverId, 0, $_POST[sceneId], $_POST[robotCount], $tNeedPlayer, $tCreateTime, $tDeleteTime)) {
				SendAlertMsg(0, $_POST[sceneId], $_POST[robotCount], $tNeedPlayer, $tCreateTime, $tDeleteTime);
				OnRecordOption($_SESSION[name], '添加机器人-'.$_POST[sceneId].",".$_POST[robotCount].",".$tNeedPlayer.",".$tCreateTime.",".$tDeleteTime, $_SESSION[DBIndex], "无");
			}
		}
	}

	if (is_array($_SESSION[ROBOT_SUB_ARRAY]) && count($_SESSION[ROBOT_SUB_ARRAY]) > 0) {
		foreach ($_SESSION[ROBOT_SUB_ARRAY] as $key => $value) {
			if ($_POST[$value]) {
				// 删除
				$param = explode("_", $value);
				if ($param[1] > 0 && OnRobotOption($conns, $serverId, $param[1], 0, 0, 0, 0, 0)) {
					//SendAlertMsg(1, $param[1], $param[2], $param[3], $param[4], $param[5]);
					OnRecordOption($_SESSION[name], '删除机器人-'.$param[1], $_SESSION[DBIndex], "无");
				}
			}
		}
	}

	echo "<form action='' method='post'><table width = '100%' class = 'robot_table'>
		<tr><th>场景</th><th>数量</th><th>状态</th><th>插入时间</th><th>操作时间</th><th>操作</th></tr>";
		if ($conns != null && $_SESSION[DBIndex] > 0 && $serverId > 0) {
			$sqls = "select * from robertcmds";
			$query = mysqli_query($conns, $sqls);
			$i = line_bg_s;
			$_SESSION[ROBOT_SUB_ARRAY] = array();
			while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
				$styleBG = ($i % line_bg_l == 0) ? "style='background-color:".line_bg_c.";'" : "";

				if ($row[isOnline] == 1) {
					$stateName = "已插入";
					$subValue = "删除";
					$residueTime = "无";
				}
				else {
					$stateName = "等待插入";
					$subValue = "取消";
					$residueTime = date("Y/m/d h:i:sa", $row[addTime]);
				}

				$subName = "rsub_".$row[cmdID];
				$runTime = date("Y/m/d h:i:sa", $row[cmdTime]);
				$optionInfo = "<input name='$subName' type='submit' value='$subValue' />";
				if ($conn) {
					$sql = "select * from option_record where `option` = '删除机器人-".$row[cmdID]."' order by id desc limit 1";
					$sQuery = mysqli_query($conn, $sql);
					if ($sRow = mysqli_fetch_array($sQuery, MYSQLI_ASSOC)) {
						$lastOptiomTime = strtotime($sRow[time]);
						// 等待60秒服务器操作
						if ($now < ($lastOptiomTime + 60)) {
							$optionInfo = "等待".$subValue."中";
						}
					}
				}

				$i++;
				echo "<tr $styleBG><td>$row[sceneID]</td><td>$row[needAdd]</td><td>$stateName</td><td>$residueTime</td><td>$runTime</td><td>$optionInfo</td></tr>";

				array_push($_SESSION[ROBOT_SUB_ARRAY], $subName);
			}
			mysqli_free_result($query);
		}
	echo "</table></form>";

	require_once("../html/bottom.html");
?>
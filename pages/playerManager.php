<?php
	$Title = "这里是角色管理页";
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

	$someType = array(
		1 => '角色名',
		2 => '账号',
		);

	$typeName = array(
		1 => '禁言',
		2 => '封号',
		3 => '踢下线',
		);
?>

<hr class = 'pm_hr' />

<form action="" method="post" class = 'pm_form'>
 	玩家：<select name='pm_some'>
				<?php
					foreach ($someType as $type => $name) {
						echo "<option value = '$type'>$name</option>";
					}
				?>
			</select>
		<input name="pm_info" type="text" style="width:100px"/><br /><br />

	操作：<select name='pm_some_op'>
				<?php
					foreach ($typeName as $type => $name) {
						echo "<option value = '$type'>$name</option>";
					}
				?>
			</select><br /><br />

	时间：<input name="pm_time" type="text" /><br /><br />

	原因：<input name="pm_reason" type="text" style="height:50px" /><br /><br />

	<input name="submitpm" type="submit" value="提交" /><br /><br />

	<p>1.禁言或者封号才需要填时间</p>
	<p>2.时间的值小于当前时间戳<br>代表禁言(或封号)到n小时后</p>
	<p>3.时间的值可以填写时间戳</p>
	<p>4.原因必填(用于记录)</p>
</form>

<form action = '' method = 'post'>
<table width = '100%' class = 'pm_table'>
		<tr><th>账号</th><th>角色名</th><th>状态</th><th>到期时间</th><th>操作者-操作时间</th><th>操作内容</th><th>操作</th></tr>
		<?php
			$conn = GetDBByIndex($_SESSION[DBIndex]);
			$serverId = GetServerId($_SESSION[DBIndex]);
			if ($_POST[submitpm]) {
				SubmitPM($conn, $serverId);
			}

			if ($conn && $_SESSION[DBIndex] > 0 && $serverId > 0) {
				$now = time();
				$sql = "select charname, accname, unblocktime, unforbidtalktime from charfulldata where worldid = '$serverId' and unblocktime > $now or unforbidtalktime > $now";

				$query = mysqli_query($conn, $sql);
				$unblockInfo = array();
				$unforbidtalkInfo = array();

				if (empty($_SESSION[unblocktime_index]) || $_SESSION[unblocktime_index] > 2000000000) {
					$_SESSION[unblocktime_index] = 1;
				}
				$i = $_SESSION[unblocktime_index];

				if (empty($_SESSION[unforbidtalktime_index]) || $_SESSION[unforbidtalktime_index] > 2000000000) {
					$_SESSION[unforbidtalktime_index] = 1;
				}
				$j = $_SESSION[unforbidtalktime_index];

				$bgi = line_bg_s;
				while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
					$styleBG = ($bgi % line_bg_l == 0) ? "style='background-color:".line_bg_c.";'" : "";
					$bgi++;
					if ($row[unblocktime] > $now) {
						$time = date("Y/m/d h:i:sa", $row[unblocktime]);
						$subName = 'submitpmtb'.$i;
						$unblockInfo[$i] = $row[charname];

						$conn0 = GetDBByIndex(0);
						$sql0 = "select * from option_record where `option` like '封号-%' and player like '%$row[charname]%' order by id desc limit 1";
						$query0 = mysqli_query($conn0, $sql0);
						$row0 = mysqli_fetch_array($query0, MYSQLI_ASSOC);

						echo "<tr $styleBG><td>$row[accname]</td><td>$unblockInfo[$i]</td><td>封号中</td><td>$time</td><td>$row0[username]-$row0[time]</td><td>$row0[option]</td><td><input name='$subName' type='submit' value='解除封号' /></td></tr>";
						$i++;
					}

					if ($row[unforbidtalktime] > $now) {
						$time = date("Y/m/d h:i:sa", $row[unforbidtalktime]);
						$subName = 'submitpmtf'.$j;
						$unforbidtalkInfo[$j] = $row[charname];

						$conn0 = GetDBByIndex(0);
						$sql0 = "select * from option_record where `option` like '禁言-%' and player like '%$row[charname]%' order by id desc limit 1";
						$query0 = mysqli_query($conn0, $sql0);
						$row0 = mysqli_fetch_array($query0, MYSQLI_ASSOC);

						echo "<tr $styleBG><td>$row[accname]</td><td>$unforbidtalkInfo[$j]</td><td>禁言中</td><td>$time</td><td>$row0[username]-$row0[time]</td><td>$row0[option]</td><td><input name='$subName' type='submit' value='解除禁言' /></td></tr>";
						$j++;
					}
				}
			}
		?>
</table>
</form>

<?php
	function SetState($conn, $serverId, $name, $type, $param, $needCommand) {
		$ret_val = false;
		if ($conn && $serverId > 0) {
			$sql = "select charname from charfulldata where worldid = '$serverId' and charname = '$name'";
			$query = mysqli_query($conn, $sql);
			if ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
				// 先确保有这个号
				if ($type == 1 || $type == 2) {
					$wSql = "update charfulldata set ";
					if ($type == 1) {
						// 解除禁言
						$wSql .= "unforbidtalktime = '$param' ";
					}
					elseif ($type == 2) {
						// 解除封号
						$wSql .= "unblocktime = '$param' ";
					}

					$wSql .= "where worldid = '$serverId' and charname = '$name'";
					mysqli_query($conn, $wSql);
				}

				if ($needCommand) {
					$cSql = "insert into gmcommand(worldid, type, command, param) values('$serverId', '3', 'rm,".$type.",".$param."', '$name')";
					mysqli_query($conn, $cSql);
				}

				$ret_val = true;
			}
		}

		return $ret_val;
	}

	function SubmitPM($conn, $serverId) {
		if ($conn == null || $_SESSION[DBIndex] <= 0 || $serverId <= 0) {
			alertMsg("请先选择服再操作");
		}
		elseif ($_POST[pm_some] == null) {
			alertMsg("请先选择玩家类型再操作");
		}
		elseif ($_POST[pm_some_op] == null) {
			alertMsg("请先选择类型再操作");
		}
		elseif ($_POST[pm_reason] == null) {
			alertMsg("请先输入原因");
		}
		else
		{
			if ($_POST[pm_time] == null) {
				$_POST[pm_time] = 0;
			}

			$op_player = '';
			if ($_POST[pm_some] == 2) {
				$sql = "select charname from charfulldata where worldid = '$serverId' and accname = '$_POST[pm_info]'";
				$query = mysqli_query($conn, $sql);
				while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
					if (SetState($conn, $serverId, $row[charname], $_POST[pm_some_op], $_POST[pm_time], true)) {
						if ($op_player == null) {
							$op_player = "账号:".$_POST[pm_info]."-".$row[charname];
						}
						else {
							$op_player .= "-".$row[charname];
						}
					}
				}
			}
			else {
				if (SetState($conn, $serverId, $_POST[pm_info], $_POST[pm_some_op], $_POST[pm_time], true)) {
					$op_player = "角色名:".$_POST[pm_info];
				}
			}

			if ($op_player) {
				OnRecordOption($_SESSION[name], $GLOBALS[typeName][$_POST[pm_some_op]]."-".$_POST[pm_time]."-原因:".$_POST[pm_reason], $_SESSION[DBIndex], $op_player);
				alertMsg("操作成功 ".$op_player." 被".$GLOBALS[typeName][$_POST[pm_some_op]]);
			}
			else {
				alertMsg("角色不存在,操作失败");
			}
		}
	}

	foreach ($unblockInfo as $key => $value) {
		$subName = 'submitpmtb'.$key;
		if ($_POST[$subName]) {
			if (SetState($conn, $serverId, $value, 2, 0, flase)) {
				OnRecordOption($_SESSION[name], "解除封号", $_SESSION[DBIndex], $value);
				$_SESSION[unblocktime_index] = $i;
				echo "<script language = 'JavaScript'> location.reload() ; </script>";
			}
		}
	}

	foreach ($unforbidtalkInfo as $key => $value) {
		$subName = 'submitpmtf'.$key;
		if ($_POST[$subName]) {
			if (SetState($conn, $serverId, $value, 1, 0, true)) {
				OnRecordOption($_SESSION[name], "解除禁言", $_SESSION[DBIndex], $value);
				$_SESSION[unforbidtalktime_index] = $j;
				echo "<script language = 'JavaScript'> location.reload() ; </script>";
			}
		}
	}

	require_once("../html/bottom.html");
?>
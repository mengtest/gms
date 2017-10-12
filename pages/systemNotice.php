<?php
	$Title = "这里是系统通告页";
	require_once("../html/header.html");
	require_once("../config/menu.php");

	// 检测登陆状态
	require_once("../script/check.php");
	$checkVal = JurisdictionCheck(basename($_SERVER["PHP_SELF"]), $_SESSION[uid]);
	if ($checkVal != 0) {
		echo "<script language=javascript>alert('$error_notice[$checkVal]');history.back();</script>";
	}

	require_once("../config/DBList.php");
	require_once("../script/selectserverbat.php");
?>

<hr class = 'notice_hr' />

<div class = 'notice_div'>
	<form action = '' method = 'post'>
		平台列表：<select name='notice_some'>
			<option value = '0'>选择后服务器号将无效</option>
			<option value = '1'>全平台</option>
			<?php
				$i = 2;
				foreach ($serverList as $plat => $idList) {
					echo "<option value = '$i'>$plat</option>";
					$i++;
				}
			?>
		</select><br/><br/><br/>
		<table width="100%">
			<tr>服务器号：<input name="notice_sid" id="my_notice_sid" type="text" value = "<?php echo $_SESSION[select_list]; ?>" style = "height:50px;width:75%" readonly/><tr>
			&nbsp;<input name = 'submitreset' type = 'submit' value = '重新输入' /><br/><br/><br/>
			<tr>内&nbsp;&nbsp;容：<input name="notice_content" type="text" style = "height:50px;width:85%" /></tr><br/><br/><br/>
			<tr><td align="left">开始时间：<input name="notice_time" type="text" title = "1.小于1亿的数(多少秒后通告);2.时间戳" /></td><td>发送条数：<input name="notice_count" type="text" /></td><td>执行间隔：<input name="notice_interval" type="text" /></td></tr>
		</table><br/><br/>
		<div align = "center">
			<input name = 'submitnotice' type = 'submit' value = '发送通告' />
		</div>
	</form>
</div>

<?php
	function SendNotice($db_index, $sql_front, $sql_end) {
		// 无效的直接过滤
		if ($db_index > 0 && $sql_front && $sql_end) {
			$conn = GetDBByIndex($db_index);
			$serverId = GetServerId($db_index);

			if ($conn && $serverId > 0) {
				// 拼接sql
				$sql = $sql_front.$serverId.$sql_end;
				mysqli_query($conn, $sql);
			}
		}
	}

	if ($_POST[submitnotice]) {
		if ($_POST[notice_content] && $_POST[notice_time] >= 0 && $_POST[notice_interval] >= 0 && $_POST[notice_count] >= 0) {
			$sqlFront = "insert into gmcommand(worldid, type, command, param) values('";
			$sqlEnd = "', '5', '$_POST[notice_content]', '";
			$sqlEnd .= ($_POST[notice_time] ? $_POST[notice_time].',' : '0,');
			$sqlEnd .= ($_POST[notice_interval] ? $_POST[notice_interval].',' : '1,');
			$sqlEnd .= ($_POST[notice_count] ? $_POST[notice_count]."')" : "1')");

			if ($_POST[notice_some]) {
				// 选了服或者平台,不读服务器号了
				if ($_POST[notice_some] == 0) {
					foreach ($serverList as $plat => $idList) {
						foreach ($idList as $serverid => $servername) {
							SendNotice($serverid, $sqlFront, $sqlEnd);
						}
					}
				}
				else {
					$i = 2;
					foreach ($serverList as $plat => $idList) {
						if ($_POST[notice_some] == $i) {
							foreach ($idList as $serverid => $servername) {
								SendNotice($serverid, $sqlFront, $sqlEnd);
							}
							break;
						}

						$i++;
					}
				}
			}
			else {
				if ($_POST[notice_sid]) {
					// 去掉最后一个字符
					$_POST[notice_sid] = substr($_POST[notice_sid], 0, strlen($_POST[notice_sid]) - 1);
					$server_arr = explode(" ,", $_POST[notice_sid]); 

					for ($i = 0; $i < count($server_arr); $i++) {
						SendNotice(substr($server_arr[$i], 1), $sqlFront, $sqlEnd);
					}
				}
				else {
					alertMsg("请先选择通告服");
				}
			}
		}
		else {
			alertMsg("请先输入通告信息");
		}
	}

	if ($_POST[submitreset]) {
		// 清除信息
		$_SESSION[select_list] = '';
		echo "<script language = 'JavaScript'> document.getElementById('my_notice_sid').value='';</script>";
	}

	require_once("../html/bottom.html");
?>
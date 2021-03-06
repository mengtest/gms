<?php
	$Title = "这里是平台管理页";
	require_once("../html/header.html");
	echo "<div class = 'shade_div4'></div>";
	require_once("../config/menu.php");
	
	// 检测登陆状态
	require_once("../script/check.php");
	$checkVal = JurisdictionCheck(basename($_SERVER["PHP_SELF"]), $_SESSION[uid]);
	if ($checkVal != 0) {
		ThrowError($checkVal);
	}

	require_once("../config/DBList.php");

	$conn = GetDBByIndex(0);
	$selfJuri = -1;
	if ($conn != null) {
		$sql = "select * from user_list where `uid` = '$_SESSION[uid]'";
		$query = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($query);

		if ($row != null && $row[jurisdiction] == 0) {
			$selfJuri = $row[jurisdiction];
		}
	}

	if ($_POST[submitplatinc] && $conn) {
		if (empty($_POST[paddrs]) || empty($_POST[puser]) || empty($_POST[pps]) || empty($_POST[pds]) ||
			empty($_POST[pdsl]) || empty($_POST[ppn]) || empty($_POST[psn]) || empty($_POST[psi])) {
			alertMsg("请先填写所有信息");
			exit();
		}

		if (!is_numeric($_POST[psi]) || $_POST[psi] <= 0) {
			alertMsg("服id必须是大于0的数字");
			exit();
		}

		$fResult = '';
		$sql = "select * from server_info where platname = '$_POST[ppn]' and servername = '$_POST[psn]'";
		$query = mysqli_query($conn, $sql);
		if ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			// 数据已经存在,更新
			$sql = "update server_info set addrs = '$_POST[paddrs]', duser = '$_POST[puser]', dpassword = '$_POST[pps]', datasource = '$_POST[pds]', datasource_log = '$_POST[pdsl]',serverid = $_POST[psi] where platname = '$_POST[ppn]' and servername = '$_POST[psn]'";
			$fResult = "更新 ";
		}
		else {
			// 数据不存在,插入
			$sql = "insert into server_info(addrs, duser, dpassword, datasource, datasource_log, platname, servername, serverid) value('$_POST[paddrs]', '$_POST[puser]', '$_POST[pps]', '$_POST[pds]', '$_POST[pdsl]', '$_POST[ppn]', '$_POST[psn]', $_POST[psi])";
			$fResult = "新增 ";
		}

		mysqli_query($conn, $sql);

		ReLoadServerConfig();

		$fResult .= "平台:".$_POST[ppn]." 服:".$_POST[psn]." 成功";
	}

	if ($_POST[submitplatsec]) {
		$_SESSION[pplat_s] = $_POST[pplat_some];
	}

	foreach ($serverList as $plat => $serverinfo) {
		$subNameM = "del".$plat;
		$finish = false;
		if ($_POST[$subNameM]) {
			// 点击了删除平台
			if (DelPlatInfo($conn, $plat, '')) {
				$fResult = "删除平台:".$plat." 成功";
			}
			break;
		}
		else {
			// 检测是否点击了该平台下的服
			foreach ($serverinfo as $index => $servername) {
				$subSNameM = "sdel".$plat.$servername;
				if ($_POST[$subSNameM]) {
					// 点击了删除服
					if (DelPlatInfo($conn, $plat, $servername)) {
						$fResult = "删除服:".$plat."-".$servername." 成功";
					}
					$finish = true;
					break;
				}
			}
		}

		if ($finish)
			break;
	}
?>

<form action="" method="post" class = 'plat_form'>
 	地址：<input name="paddrs" type="text" title="数据库连接地址"/>
 	用户名：<input name="puser" type="text" title="数据库连接用户名"/>
 	密码：<input name="pps" type="text" title="数据库连接密码"/>
 	数据源：<input name="pds" type="text" />
 	日志数据源：<input name="pdsl" type="text" /><br /><br />
 	平台名：<input name="ppn" type="text" />
 	服名：<input name="psn" type="text" />
 	服id：<input name="psi" type="text" title="必须大于0"/>
 	<input name="submitplatinc" type="submit" title="当平台名和服名都存在就更新" value="新增或更新" />
</form>

<hr class = 'plat_hr' />

<form action="" method="post" class = 'plat_form2'>
	<?php
		echo "<select name='pplat_some'>";
		echo "<option value='' $select>全平台</option>";
		foreach ($serverList as $plat => $idList) {
			$select = $_SESSION[pplat_s] == $plat ? ' selected' : '';
			echo "<option value='$plat' $select>$plat</option>";
 		}
 		echo "</select>";
	?>
 	<input name="submitplatsec" type="submit" value="选择平台" />
</form>

<input type="text" class="plat_text" value = "<?php echo $fResult; ?>" readonly/>

<form action="" method="post">
<table width = '100%' class = 'plat_table'>
	<tr><th>平台名</th><th>服名称</th><th>服id</th><th>链接地址</th><th>数据源</th><th>日志数据源</th><th>操作</th></tr>
	<?php
		if ($_SESSION[pplat_s]) {
			ShowServerInfo($_SESSION[pplat_s], $serverList[$_SESSION[pplat_s]]);
		}
		else {
			foreach ($serverList as $plat => $idList) {
				ShowServerInfo($plat, $idList);
			}
		}
	?>
</table>
</form>

<?php
	function ShowServerInfo($plat, $serverinfo) {
		$subName = "del".$plat;
		$styleBG2 = "style='background-color:".line_bg_c2.";'";
		echo "<tr $styleBG2><th>$plat</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th><input name='$subName' type='submit' value='删除' /></th></tr>";

		$i = line_bg_s;
		foreach ($serverinfo as $index => $servername) {
			$i++;
			$styleBG = ($i % line_bg_l == 0) ? "style='background-color:".line_bg_c.";'" : "";
			$subSName = "sdel".$plat.$servername;
			echo "<tr $styleBG><td>$plat</td><td>$servername</td><td>".GetServerId($index)."</td><td>".GetDBAddrs($index)."</td><td>".GetDBSource($index)."</td><td>".GetLogDBSource($index)."</td><td><input name='$subSName' type='submit' value='删除' /></td></tr>";
		}
	}

	function DelPlatInfo($conn, $platName, $serverName) {
		if ($conn == null || empty($platName)) {
			return false;
		}

		$sql = "delete from server_info where platname = '$platName'";
		if ($serverName) {
			$sql .= " and servername = '$serverName'";
		}

		mysqli_query($conn, $sql);

		ReLoadServerConfig();
		return true;
	}

	require_once("../html/bottom.html");
?>
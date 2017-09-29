<?php
	// 屏蔽提示
	error_reporting(E_ALL || ~E_NOTICE);

	$Title = "这里是GM命令页";
	require_once("../html/header.html");
	require_once("../config/menu.php");

	require_once("check.php");
	require_once("../config/DBList.php");
	require_once("optionrecord.php");
	require_once("selectserver.php");
	
	// 检测登陆状态
	$checkVal = JurisdictionCheck(basename($_SERVER["PHP_SELF"]), $_SESSION[uid]);
	if ($checkVal != 0) {
		echo "<script language=javascript>alert('$error_notice[$checkVal]');history.back();</script>";
	}
?>

<form action="" method="post" class = 'command_form2'>
 	<!--服id：<input name="serverid" type="text" />-->
 	类型：<input name="type" type="text" />
 	命令：<input name="command" type="text" />
 	参数：<input name="param" type="text" />
 	<input name="submitcommand" type="submit" value="提交" />
</form>

<hr class = 'command_hr' />

<!--<form action="" method="post" class = 'command_form2'>
	筛选服id：<input name="serverid" type="text" />
 	<input name="submitcommand2" type="submit" value="选择" />
</form>-->

<table width = '100%' class = 'command_table'>
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

		function GetGMCommandInfo($sid) {
			$conn = GetDBByIndex($sid);
			if ($conn != null) {
				$sql = "select * from gmcommand where worldid = '$sid'";
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


<?php
	if($_POST[submitcommand]){
		$conn = GetDBByIndex($_SESSION[DBIndex]);
		if ($conn == null || $_SESSION[DBIndex] <= 0) {
			alertMsg("请先选择服再操作");
		}
		else {
			$sql = "insert into gmcommand(worldid, type, command, param) values('$_SESSION[DBIndex]', '$_POST[type]', '$_POST[command]', '$_POST[param]')";
			mysqli_query($conn, $sql);
		
			if ($_POST[type] == 1) {
				OnRecordOptionGuid($_SESSION[name], 'GM命令-'.$_POST[command], $_SESSION[DBIndex], $_POST[param]);
			}
			else {
				OnRecordOption($_SESSION[name], 'GM命令-'.$_POST[command], $_SESSION[DBIndex], $_POST[param]);
			}

			echo "<script language = 'JavaScript'> location.reload() ; </script>";
		}
	}

	/*if($_POST[submitcommand2]){
		if ($_SESSION[DBIndex] != $_POST[serverid]) {
			$conn = GetDBByIndex($_POST[serverid]);
			if ($conn != null) {
				$_SESSION[DBIndex] = $_POST[serverid];
				header("Location: #");
			}
		}
	}*/

	require_once("../html/bottom.html");
?>
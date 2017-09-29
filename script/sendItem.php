<?php
	// 屏蔽提示
	error_reporting(E_ALL || ~E_NOTICE);

	$Title = "这里是物品发放页";
	require_once("../html/header.html");
	require_once("../config/menu.php");

	// 检测登陆状态
	require_once("check.php");
	$checkVal = JurisdictionCheck(basename($_SERVER["PHP_SELF"]), $_SESSION[uid]);
	if ($checkVal != 0) {
		echo "<script language=javascript>alert('$error_notice[$checkVal]');history.back();</script>";
	}

	require_once("../config/DBList.php");
	require_once("selectserver.php");
	require_once("optionrecord.php");
?>

<form action="" method="post" class = 'item_form'>
 	<font align="center">guid(多个guid可用','隔开)</font><br />
 	<input name="playerguid" type="text" style="height:50px"/><br /><br />
 	<font align="center">name(多个名称可用','隔开)</font><br />
 	<input name="playername" type="text" style="height:50px"/><br /><br />
 	<font align="center">item(银两,元宝,灵玉,银票,<br />itemId,num,isBind<br />后面还有物品可以用','隔开)</font><br />
 	<input name="iteminfo" type="text" style="height:50px"/><br />
 	<input name="submitItem" type="submit" value="发放物品" />
</form>

<hr class = 'item_hr' />

<?php
	$conn = GetDBByIndex(0);
	echo "<table width = '100%' class = 'item_table'>
		<tr><th>操作者</th><th>发放内容</th><th>操作服</th><th>玩家信息</th><th>时间</th></tr>";
		if ($conn != null) {
			// 只查找发放物品的信息
			$sql = "select * from option_record where `option` like '发放物品-%' order by id desc";
			//$sql = "select * from option_record order by id desc";
			$query = mysqli_query($conn, $sql);
			while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
				echo "<tr><th>$row[username]</th><th>$row[option]</th><th>$row[optionserver]</th><th>$row[player]</th><th>$row[time]</th></tr>";
			}
			mysqli_free_result($query);
		}
	echo "</table>";

	if($_POST[submitItem]){
		$conns = GetDBByIndex($_SESSION[DBIndex]);
		if ($conn == null || $conns == null || $_SESSION[DBIndex] <= 0) {
			alertMsg("请先选择服再操作");
			exit();
		}

		if ($_POST[iteminfo] == null) {
			alertMsg("没有物品内容");
			exit();
		}

		$sqls = "insert into gmcommand(worldid, type, command, param) values";
		$playinfo = null;
		if ($_POST[playerguid] != null) {
			$playinfo = $_POST[playerguid].'-';

			//$sqlguid = $sqls;
			$sqlinc = "('$_SESSION[DBIndex]', '1', 'itemlist,$_POST[iteminfo]', ";
			$guidArr = explode(",", $_POST[playerguid]);
			for ($i = 0; $i < count($guidArr); $i++) {
				if ($i > 0) {
					$sqls = $sqls.','.$sqlinc."'".$guidArr[$i]."')";
				}
				else {
					$sqls = $sqls.$sqlinc."'".$guidArr[$i]."')";
				}
			}
		}

		if ($_POST[playername] != null) {
			$playinfo = $playinfo.$_POST[playername];

			$sqlinc2 = "('$_SESSION[DBIndex]', '2', 'itemlist,$_POST[iteminfo]', ";
			if ($_POST[playerguid] != null) {
				$sqls = $sqls.",";
			}

			$nameArr = explode(",", $_POST[playername]);
			for ($i = 0; $i < count($nameArr); $i++) {
				if ($i > 0) {
					$sqls = $sqls.','.$sqlinc2."'".$nameArr[$i]."')";
				}
				else {
					$sqls = $sqls.$sqlinc2."'".$nameArr[$i]."')";
				}
			}
		}

		if ($playinfo != null) {
			mysqli_query($conns, $sqls);

			OnRecordOption($_SESSION[name], '发放物品-'.$_POST[iteminfo], $_SESSION[DBIndex], $playinfo);
		}
	}

	require_once("../html/bottom.html");
?>
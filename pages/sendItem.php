<?php
	$Title = "这里是物品发放页";
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

<form action="" method="post" class = 'item_form'>
 	<font align="center">guid(多个guid可用','隔开)</font><br />
 	<input name="playerguid" type="text" style="height:50px"/><br /><br />
 	<font align="center">name(多个名称可用' '隔开)</font><br />
 	<input name="playername" type="text" style="height:50px"/><br /><br />
 	<font align="center">item(银两,元宝,灵玉,银票,<br />itemId,num,isBind<br />后面还有物品可以用','隔开)</font><br />
 	<input name="iteminfo" type="text" style="height:50px"/><br />
 	<input name="submitItem" type="submit" value="发放物品" />
</form>

<hr class = 'item_hr' />

<?php
	$conn = GetDBByIndex(0);

	if($_POST[submitItem]){
		$conns = GetDBByIndex($_SESSION[DBIndex]);
		$serverId = GetServerId($_SESSION[DBIndex]);
		if ($conn == null || $conns == null || $_SESSION[DBIndex] <= 0 || $serverId <= 0) {
			alertMsg("请先选择服再操作");
		}
		elseif ($_POST[iteminfo] == null) {
			alertMsg("没有物品内容");
		}
		else {
			$sqls = "insert into gmcommand(worldid, type, command, param) values";
			$playinfo = null;
			if ($_POST[playerguid] != null) {
				$playinfo = $_POST[playerguid].'-';

				//$sqlguid = $sqls;
				$sqlinc = "('$serverId', '1', 'itemlist,$_POST[iteminfo]', ";
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

				$sqlinc2 = "('$serverId', '2', 'itemlist,$_POST[iteminfo]', ";
				if ($_POST[playerguid] != null) {
					$sqls = $sqls.",";
				}

				$nameArr = explode(" ", $_POST[playername]);
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
	}

	$option_table = 'item_table';
	$sql = "select * from option_record where `option` like '发放物品-%' order by id desc";
	require_once("../script/optionTable.php");

	require_once("../html/bottom.html");
?>
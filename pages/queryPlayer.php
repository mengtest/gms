<?php
	// 屏蔽提示
	error_reporting(E_ALL || ~E_NOTICE);

	$Title = "这里是角色查询页";
	require_once("../html/header.html");
	require_once("../config/menu.php");

	// 检测登陆状态
	require_once("../script/check.php");
	$checkVal = JurisdictionCheck(basename($_SERVER["PHP_SELF"]), $_SESSION[uid]);
	if ($checkVal != 0) {
		echo "<script language=javascript>alert('$error_notice[$checkVal]');history.back();</script>";
	}

	require_once("../config/DBList.php");
	require_once("../script/selectserver.php");
?>

<form action="" method="post" class = 'query_form'>
 	<!--服id：<input name="serverid" type="text" /><br />-->
 	Guid：<input name="playerguid" type="text" />
 	名称：<input name="playername" type="text" />
 	账号：<input name="account" type="text" />
 	<input name="submitquery" type="submit" value="查询" />
</form>

<hr class = 'query_hr' />

<?php
	echo "<table width = '100%' class = 'query_table'>
			<tr><th>服id</th><th>guid</th><th>玩家名</th><th>账号</th><th>职业</th><th>等级</th><th>VIP</th></tr>";

	if($_POST[submitquery]){
		$conn = GetDBByIndex($_SESSION[DBIndex]);
		$serverId = GetServerId($_SESSION[DBIndex]);
		if ($conn == null || $_SESSION[DBIndex] <= 0 || $serverId <= 0) {
			alertMsg("请先选择服再操作");
			exit();
		}

		$playerguid = $_POST[playerguid] != null ? $_POST[playerguid] : 0;
		$playername = $_POST[playername] != null ? $_POST[playername] : '';
		$account = $_POST[account] != null ? $_POST[account] : '';

		$sql = "select * from charfulldata where worldid = $serverId and ($playerguid = 0 or guid = $playerguid) and ('$playername' = '' or charname = '$playername') and ('$account' = '' or accname = '$account')";
		$query = mysqli_query($conn, $sql);

		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			echo "<tr><th>$row[worldid]</th><th>$row[guid]</th><th>$row[charname]</th><th>$row[accname]</th><th>$row[profession]</th><th>$row[level]</th><th>$row[nvipcost]</th></tr>";
		}
	}

	echo "</table>";

	require_once("../html/bottom.html");
?>
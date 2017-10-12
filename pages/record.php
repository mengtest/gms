<?php
	// 屏蔽提示
	error_reporting(E_ALL || ~E_NOTICE);

	$Title = "这里是操作记录页";
	require_once("../html/header.html");
	require_once("../config/menu.php");
	
	// 检测登陆状态
	require_once("../script/check.php");
	$checkVal = JurisdictionCheck(basename($_SERVER["PHP_SELF"]), $_SESSION[uid]);
	if ($checkVal != 0) {
		echo "<script language=javascript>alert('$error_notice[$checkVal]');history.back();</script>";
	}

	require_once("../config/DBList.php");
?>

<!--<table width = '100%' class = 'record_table'>
	<tr><th>名称</th><th>操作信息</th><th>操作服</th><th>玩家信息</th><th>时间</th></tr>
	<?php
		/*$conn = GetDBByIndex(0);
		if ($conn != null) {
			$sql = "select * from option_record order by id desc";
			$query = mysqli_query($conn, $sql);
			while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
				echo "<tr><th>$row[username]</th><th>$row[option]</th><th>$row[optionserver]</th><th>$row[player]</th><th>$row[time]</th></tr>";
			}
			mysqli_free_result($query);
			mysqli_close($conn);
		}*/
	?>
</table>-->

<form action="" method="post" class = 'record_form'>
 	操作者：<input name="reusername" type="text" value="<?php echo $_SESSION[rusername]; ?>" style="width:100px" title = "完整名称" />
 	内容：<input name="reoption" type="text" value="<?php echo $_SESSION[roption]; ?>" style="width:150px" title = "填写关键词即可" />
 	服：<input name="reserver" type="text" value="<?php echo $_SESSION[rserver]; ?>" style="width:100px" title = "填写关键词即可" />
 	玩家：<input name="replayer" type="text" value="<?php echo $_SESSION[rplayer]; ?>" style="width:100px" title = "填写关键词即可" />
 	时间：<input name="retime" type="text" value="<?php echo $_SESSION[rtime]; ?>" style="width:100px" title = "如:2017/10/11" />
 	查询条数：<input name="relimit" type="text" value="<?php echo $_SESSION[rlimit]; ?>" style="width:50px" title = "不填代表查询全部" />
 	<input name="submitrecord" type="submit" value="查询" />
</form>

<?php
	$conn = GetDBByIndex(0);
	$option_table = 'record_table';
	$sql = "select * from option_record ";
	$sqlinc = '';
	if ($_SESSION[rusername]) {
		$sqlinc = "where '$_SESSION[rusername]' = username ";
	}

	if ($_SESSION[roption]) {
		if ($sqlinc) {
			$sqlinc .= "and ";
		}
		else {
			$sqlinc = "where ";
		}
		$sqlinc .= "`option` like '%$_SESSION[roption]%' ";
	}

	if ($_SESSION[rserver]) {
		if ($sqlinc) {
			$sqlinc .= "and ";
		}
		else {
			$sqlinc = "where ";
		}
		$sqlinc .= "optionserver like '%$_SESSION[rserver]%' ";
	}

	if ($_SESSION[rplayer]) {
		if ($sqlinc) {
			$sqlinc .= "and ";
		}
		else {
			$sqlinc = "where ";
		}
		$sqlinc .= "player like '%$_SESSION[rplayer]%' ";
	}

	if ($_SESSION[rtime]) {
		if ($sqlinc) {
			$sqlinc .= "and ";
		}
		else {
			$sqlinc = "where ";
		}
		$sqlinc .= "`time` like '%$_SESSION[rtime]%' ";
	}

	$sql .= $sqlinc."order by id desc";
	if (is_numeric($_SESSION[rlimit]) && $_SESSION[rlimit] > 0) {
		$sql .= " limit $_SESSION[rlimit]";
	}

	require_once("../script/optionTable.php");

	if ($_POST[submitrecord]) {
		$flushPage = false;

		if ($_SESSION[rusername] != $_POST[reusername]) {
			$_SESSION[rusername] = $_POST[reusername];
			$flushPage = true;
		}

		if ($_SESSION[roption] != $_POST[reoption]) {
			$_SESSION[roption] = $_POST[reoption];
			$flushPage = true;
		}

		if ($_SESSION[rserver] != $_POST[reserver]) {
			$_SESSION[rserver] = $_POST[reserver];
			$flushPage = true;
		}

		if ($_SESSION[rplayer] != $_POST[replayer]) {
			$_SESSION[rplayer] = $_POST[replayer];
			$flushPage = true;
		}

		if ($_SESSION[rtime] != $_POST[retime]) {
			$_SESSION[rtime] = $_POST[retime];
			$flushPage = true;
		}

		if ($_SESSION[rlimit] != $_POST[relimit]) {
			$_SESSION[rlimit] = $_POST[relimit];
			$flushPage = true;
		}

		if ($flushPage) {
			echo "<script language = 'JavaScript'> location.reload() ; </script>";
		}
	}

	require_once("../html/bottom.html");
?>
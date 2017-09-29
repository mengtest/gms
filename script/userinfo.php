<?php
	// 屏蔽提示
	error_reporting(E_ALL || ~E_NOTICE);

	$Title = "这里是角色编辑页";
	require_once("../html/header.html");
	require_once("../config/menu.php");
	
	// 检测登陆状态
	require_once("check.php");
	$checkVal = JurisdictionCheck(basename($_SERVER["PHP_SELF"]), $_SESSION[uid]);
	if ($checkVal != 0) {
		echo "<script language=javascript>alert('$error_notice[$checkVal]');history.back();</script>";
	}

	require_once("../config/DBList.php");
	require_once("../config/CommomConfig.php");

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
?>

<form action="" method="post" class = 'userinfo_form'>
 	角色id：<input name="uid1" type="text" /><tr />
 	角色名：<input name="uname1" type="text" /><tr />
 	权限：<input name="uJuri" type="text" /><tr />
 	<input name="submituser" type="submit" value="修改权限" />
</form>

<hr class = 'userinfo_hr2' />

<form action="" method="post" class = 'userinfo_form2'>
 	角色id：<input name="uid2" type="text" /><tr />
 	角色名：<input name="uname2" type="text" /><tr />
 	新密码：<input name="password1" type="password" /><tr />
 	新密码：<input name="password2" type="password" /><tr />
 	<input name="submituser2" type="submit" value="修改密码" />
</form>

<hr class = 'userinfo_hr' />

<form action="" method="post" class = 'userinfo_form3'>
 	权限：<input name="uJuri3" type="text" /><tr />
 	角色名：<input name="uname3" type="text" /><tr />
 	密码：<input name="password3" type="password" /><tr />
 	密码：<input name="password4" type="password" /><tr />
 	<input name="submituser3" type="submit" value="创建角色" />
</form>

<hr class = 'userinfo_hr3' />

<table width = '100%' class = 'userinfo_table'>
	<tr><th>uid</th><th>权限</th><th>角色名</th></tr>
	<?php
		if ($conn != null) {
			$sql = "select * from user_list";
			$query = mysqli_query($conn, $sql);
			while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
				echo "<tr><th>$row[uid]</th><th>$row[jurisdiction]</th><th>$row[username]</th></tr>";
			}
			mysqli_free_result($query);
		}
	?>
</table>


<?php
	if($_POST[submituser]){
		if ($selfJuri >= 0 && $_POST[uJuri] >= $selfJuri)
		{
			if ($conn != null && $_POST[uJuri] >= 0) {
				$sql = "update user_list set jurisdiction = '$_POST[uJuri]' where ('$_POST[uid1]' = '' or `uid` = '$_POST[uid1]') and ('$_POST[uname1]' = '' or `username` = '$_POST[uname1]')";
				mysqli_query($conn, $sql);
				header("Location: #");
			}
		}
		else {
			alertMsg("权限不足");
		}
	}

	if($_POST[submituser2]){
		if ($selfJuri == 0)
		{
			if ($_POST[password1] != $_POST[password2] || $_POST[password1] == null) {
				alertMsg("密码不可为空,或者两次输入不一致");
				exit();
			}

			if ($conn != null) {
				$newps = md5($_POST[password1].MD5_encrypt);
				$sql = "update user_list set password = '$newps' where ('$_POST[uid2]' = '' or `uid` = '$_POST[uid2]') and ('$_POST[uname2]' = '' or `username` = '$_POST[uname2]')";
				mysqli_query($conn, $sql);
				alertMsg("密码修改成功");
			}
		}
		else {
			alertMsg("权限不足");
		}
	}

	if($_POST[submituser3]){
		if ($selfJuri == 0)
		{
			if ($_POST[password3] != $_POST[password4] || $_POST[password3] == null) {
				alertMsg("密码不可为空,或者两次输入不一致");
				exit();
			}

			if ($_POST[uJuri3] == null || $_POST[uJuri3] < 0) {
				alertMsg("设置的权限非法");
				exit();
			}

			if ($_POST[uname3] == null || $_POST[uname3] == '') {
				alertMsg("设置的名字非法");
				exit();
			}

			if ($conn != null) {
				$sql = "select * from user_list where `username` = '$_POST[uname3]'";
				$query = mysqli_query($conn, $sql);
				$row = mysqli_fetch_array($query);
				if ($row != null) {
					alertMsg("该用户已存在");
					exit();
				}

				$newps = md5($_POST[password3].MD5_encrypt);
				$sql = "insert into user_list(jurisdiction, username, password) value($_POST[uJuri3], '$_POST[uname3]', '$newps')";
				echo $sql;
				mysqli_query($conn, $sql);
				alertMsg("用户创建成功");
				header("Location: #");
			}
		}
		else {
			alertMsg("权限不足");
		}
	}

	require_once("../html/bottom.html");
?>
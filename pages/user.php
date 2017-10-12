<?php
	$Title = "这里是角色信息页";
	require_once("../html/header.html");
	require_once("../config/menu.php");

	if ($_SESSION[uid] == null) {
		header("Location: login");
		exit();
	}

	require_once("../config/CommomConfig.php");
	require_once("../config/DBList.php");

	$conn0 = GetDBByIndex(0);
	$row = null;
	if ($conn0 != null) {
		$sql = "select * from user_list where `uid` = '$_SESSION[uid]'";
		$query = mysqli_query($conn0, $sql);
		$row = mysqli_fetch_array($query);

		if ($row != null && $row[jurisdiction] == 0) {
			echo "<a href='userInfo' class='rightfixed2'>角色权限设置</a>";
		}
	}
?>

<form action="" method="post" class = 'changeps_form'>
 	旧密码：<input name="password1" type="password" /><br />
 	新密码：<input name="password2" type="password" /><br />
 	新密码：<input name="password3" type="password" /><br />
 	<input name="submitps" type="submit" value="修改密码" />
</form>

<?php
	if($_POST[submitps]){
		if ($_POST[password1] == null || $_POST[password2] == null || $_POST[password3] == null) {
			alertMsg("密码不能为空");
		}
		else {
			if ($_POST[password2] != $_POST[password3]) {
				alertMsg("2次输入的密码不一致");
			}
			else {
				if ($row != null) {
					$ps = is_array($row) ? md5($_POST[password1].MD5_encrypt) == $row[password] : false;

					if ($ps) {
						$newpassword = md5($_POST[password2].MD5_encrypt);
						$sql2 = "update user_list set password = '$newpassword' where `uid` = '$_SESSION[uid]'";
						mysqli_query($conn0, $sql2);

						alertMsg("密码修改成功");
					}
					else {
						alertMsg("旧密码错误");
					}
				}
			}
		}
	}

	require_once("../html/bottom.html");
?>
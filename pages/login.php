<?php
	// 屏蔽提示
	error_reporting(E_ALL || ~E_NOTICE);

	$Title = "这里是登陆页";
	require_once("../html/header.html");
	require_once("../config/menu.php");

	if ($_SESSION[uid] != null) {
		header("Location: ../");
		exit();
	}

	require_once("../config/CommomConfig.php");
	require_once("../config/DBList.php");
?>

<form action="" method="post" class = 'login_form'>
 	用户名：<input name="username" type="text" /><br />
 	密&nbsp;码：<input name="password" type="password" /><br />
 	<input name="submit" type="submit" value="登录" />
</form>

<?php
	if($_POST[submit]){
		$conn0 = GetDBByIndex(0);
		if ($conn0 == null) {
			session_destroy();
			exit();
		}

		$username = str_replace(" ","","$_POST[username]");
		$sql = "select * from user_list where `username` = '$username'";
		$query = mysqli_query($conn0, $sql);
		$row = mysqli_fetch_array($query);

		if ($row == null) {
			alertMsg("用户名不存在");
			session_destroy();
		}
		else {
			$ps = is_array($row) ? md5($_POST[password].MD5_encrypt) == $row[password] : false;
			if ($ps) {
				$_SESSION[uid] = $row[uid];
				$_SESSION[name] = $row[username];

				echo "<script language = 'JavaScript'> location.reload() ; </script>";
			}
			else {
				alertMsg("用户名或密码错误");
				session_destroy();
			}
		}
	}

	require_once("../html/bottom.html");
?>
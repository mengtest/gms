<?php
	// 屏蔽提示
	error_reporting(E_ALL || ~E_NOTICE);

	$Title = "这里是主页";
	require_once("html/header.html");
	require_once("config/menu.php");

	if ($_SESSION[name] != null) {
		echo "<a href='script/user.php' class='rightfixed2'>$_SESSION[name]</a>";
		echo "<a href='script/logout.php' class='rightfixed'>登出</a>";
	}
	else {
		echo "<a href='script/login.php' class='rightfixed'>登陆</a>";
	}

	require_once("html/bottom.html");
?>
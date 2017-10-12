<?php
	$Title = "这里是主页";
	require_once("html/header.html");
	require_once("config/menu.php");

	if ($_SESSION[name] != null) {
		echo "<a href='user' class='rightfixed2'>$_SESSION[name]</a>";
		echo "<a class='rightfixed' onclick='clickLogout()'>登出</a>";
	}
	else {
		echo "<a href='login' class='rightfixed'>登陆</a>";
	}

	echo "<div class = 'helper_div'>";
	require_once("config/helper.html");
	echo "</div>";

	echo "<script language=javascript>function clickLogout() {var con = confirm('确定登出?');if (con) {self.location='logout'; }}</script>";

	require_once("html/bottom.html");
?>
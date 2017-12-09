<?php
	$Title = "这里是主页";
	require_once("html/header.html");
	require_once("config/menu.php");

	echo "<div class = 'helper_div'>";
	$special = $_SESSION[uid] ? '' : 'display:none;';
	require_once("config/helper.html");
	echo "</div>";

	require_once("html/bottom.html");
?>
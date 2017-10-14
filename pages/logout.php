<?php
	$absolute_path = dirname(dirname(__FILE__));
	require_once("$absolute_path/config/CommomConfig.php");

	// 只要执行就销毁一次session(无论有无)
	session_start();
	echo "<script language = 'JavaScript'> window.location.href='".host_addr."'; </script>";
	session_destroy();
?>
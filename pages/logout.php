<?php
	// 屏蔽提示
	error_reporting(E_ALL || ~E_NOTICE);

	$absolute_path = dirname(dirname(__FILE__));
	require_once("$absolute_path/config/CommomConfig.php");

	// 只要执行就销毁一次session(无论有无)
	session_start();
	$reback_str = "<script language = 'JavaScript'> window.location.href='".host_addr."'; </script>";
	echo $reback_str;
	session_destroy();
?>
<?php
	// 屏蔽提示
	error_reporting(E_ALL || ~E_NOTICE);

	// 只要执行就销毁一次session(无论有无)
	session_start();
	header("Location: ../");
	session_destroy();
?>
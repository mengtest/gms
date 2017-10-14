<?php
	// 屏蔽提示
	error_reporting(E_ALL || ~E_NOTICE);

	$absolute_path = dirname(dirname(__FILE__));

	// 设置默认时区为北京
	date_default_timezone_set('PRC');

	if ($_GET[requrl] == null) {
		// 请求主页
		require_once("$absolute_path/index.php");
	}
	else {
		$script_path = $absolute_path.'/pages/'.$_GET[requrl].'.php';
		if (file_exists($script_path)) {
			include_once("$script_path");
		}
		else {
			require_once("$absolute_path/html/404.html");
		}
	}
?>
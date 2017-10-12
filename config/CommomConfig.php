<?php
	// 定义加密信息
	define("MD5_encrypt", "f98e3fd3f9051b1");

	// 定义主机地址
	define("host_addr", 'http://192.168.1.116:8550/gms/');

	// 定义热云地址
	define("hotcloud_addr", 'http://localhost:8550/gms/');

	// 定义每行显示平台数
	define("plat_num", 3);

	// 定义每页显示平台数(要是上面的倍数)
	define("plat_page", 9);

	// 定义最大vip等级
	define("vip_max", 7);

	// 定义菜单高度百分比
	define("menu_height", 9);

	// 定义错误信息
	$error_notice = array(
		0 => '成功', 
		1 => 'Session信息异常', 
		2 => '数据库连接异常', 
		3 => '权限不足', 
		);
?>
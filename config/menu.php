<?php
	if (visitLimit == null || visitLimit != 1)
	{
		exit("不可访问");
	}

	$absolute_path = dirname(__FILE__);
	require_once("$absolute_path/CommomConfig.php");

	$hot_cloud_addr = hotcloud_addr;
	echo "<div class = 'hotcloud_fixed'><a href = '$hot_cloud_addr'>前往热云</a></div>";

	echo "<div class = 'leftfixed'><ul style='position: absolute; height: 100%;'>";

		// 主页
		$index_addr = host_addr;
		echo "<li style = 'height: 10%;'><a href='$index_addr' class = 'menufixed'>主页</a></li>";

		$page_addr = host_addr . 'pages/';

		// 操作记录页
		$record_addr = $page_addr . 'record.php';
		echo "<li style = 'height: 10%;'><a href='$record_addr' class = 'menufixed'>操作记录</a></li>";

		// 角色查询页
		$query_addr = $page_addr . 'queryPlayer.php';
		echo "<li style = 'height: 10%;'><a href='$query_addr' class = 'menufixed'>查询角色</a></li>";

		// 角色查询页
		$item_addr = $page_addr . 'sendItem.php';
		echo "<li style = 'height: 10%;'><a href='$item_addr' class = 'menufixed'>发放物品</a></li>";

		// GM命令
		$gm_addr = $page_addr . 'GMCommand.php';
		echo "<li style = 'height: 10%;'><a href='$gm_addr' class = 'menufixed'>GM命令</a></li>";

	echo "</ul></div>";
?>
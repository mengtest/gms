<?php
	$absolute_path = dirname(__FILE__);
	require_once("$absolute_path/CommomConfig.php");

	// 修改menu只需改这个数组就ok
	$menuArr = array(
		'主页' => host_addr, 
		'操作记录' => host_addr . 'record', 
		'角色查询' => host_addr . 'queryPlayer', 
		'系统通告' => host_addr . 'systemNotice', 
		'物品发放' => host_addr . 'sendItem', 
		'GM命令' => host_addr . 'GMCommand', 
		);

	$hot_cloud_addr = hotcloud_addr;
	echo "<div class = 'hotcloud_fixed'><a href = '$hot_cloud_addr'>前往热云</a></div>";

	echo "<div class = 'leftfixed'><ul style='position: absolute; height: 100%;'>";

	foreach ($menuArr as $pname => $paddr) {
		echo "<li style = 'height: 10%;'><a href='$paddr' class = 'menufixed'>$pname</a></li>";
	}

	echo "</ul></div>";
?>
<?php
	$absolute_path = dirname(__FILE__);
	require_once("$absolute_path/CommomConfig.php");
	require_once("$absolute_path/FileJurisdiction.php");

	// 修改menu只需改这个数组就ok
	$menuArr = array(
		'主页' => host_addr, 
		'操作记录' => 'record', 
		'角色查询' => 'queryPlayer', 
		'角色管理' => 'playerManager', 
		'系统通告' => 'systemNotice', 
		'发送邮件' => 'sendMail', 
		'物品发放' => 'sendItem', 
		'GM命令' => 'GMCommand', 
		'平台管理' => 'platManager',
		);

	$hot_cloud_addr = hotcloud_addr;
	echo "<div class = 'hotcloud_fixed'><a href = '$hot_cloud_addr'>前往热云</a></div>";

	$styleBG2 = "style='background-color:".menu_bg_c.";'";
	echo "<div class = 'leftfixed' $styleBG2><ul style='position: absolute; height: 100%;'>";

	foreach ($menuArr as $pname => $paddr) {
		$Juri = GetJurisdiction($paddr.'.php');

		if ($Juri < 0 || ($_SESSION[uid] && $_SESSION[Juri] <= $Juri)) {
			//$href_addr = host_addr.$paddr;
			echo "<li style = 'height: ".menu_height."%;'><a href='$paddr' class = 'menufixed'>$pname</a></li>";
		}
	}

	echo "</ul></div>";

	if ($_SESSION[name]) {
		echo "<a href='user' class='rightfixed2'>$_SESSION[name]</a>";
		echo "<a class='rightfixed' onclick='clickLogout()'>登出</a>";
	}
	else {
		echo "<a href='login' class='rightfixed'>登陆</a>";
	}

	echo "<script language=javascript>
		function clickLogout() {
			var con = confirm('确定登出?');
			if (con) {self.location='logout'; }
		}
		</script>";
?>
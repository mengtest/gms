<?php
	// 获取数据库函数
	function GetDBByIndex($index) {
		$conn = null;

		switch ($index) {
			case 0:
			{
				/*
				** 设置DB信息(数据库地址， 用户名， 密码)
				** 设置数据库名称
				*/
				$conn = mysqli_connect('localhost','root','root');
				mysqli_select_db($conn, 'test');
			}
			break;

			case 100:
			{
				$conn = mysqli_connect('localhost','root','root');
				mysqli_select_db($conn, '3dmmo');
			}
			break;

			case 106:
			case 107:
			case 108:
			case 109:
			case 110:
			case 111:
			case 117:
			{
				$conn = mysqli_connect('192.168.1.117','root','root');
				mysqli_select_db($conn, 'mtlbbdb_100');
			}
			break;
			
			default:
				break;
		}

		if ($conn == null) {
			echo 'Could not connect:<br>' . mysqli_error();
		}

		return $conn;
	}

	// 服列表
	$serverList = array(
		'本地服0' => array(
			100 => 's100(本地)',
			117 => 's117(内网)', 
			), 
		'本地服1' => array(
			106 => 's106(内网)',
			107 => 's107(内网)', 
			), 
		'本地服2' => array(
			108 => 's108(内网)',
			109 => 's109(内网)', 
			), 
		'本地服3' => array(
			110 => 's110(内网)',
			111 => 's111(内网)', 
			), 
		'本地服4' => array(
			110 => 's110(内网)',
			111 => 's111(内网)', 
			), 
		'本地服5' => array(
			110 => 's110(内网)',
			111 => 's111(内网)', 
			), 
		'本地服6' => array(
			110 => 's110(内网)',
			111 => 's111(内网)', 
			), 
		'本地服7' => array(
			110 => 's110(内网)',
			111 => 's111(内网)', 
			), 
		'本地服8' => array(
			110 => 's110(内网)',
			111 => 's111(内网)', 
			), 
		'本地服9' => array(
			110 => 's110(内网)',
			111 => 's111(内网)', 
			), 
		'本地服10' => array(
			110 => 's110(内网)',
			111 => 's111(内网)', 
			), 
		'本地服11' => array(
			110 => 's110(内网)',
			111 => 's111(内网)', 
			), 
		);
?>
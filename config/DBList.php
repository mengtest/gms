<?php
	/*
	** 可以多个index对应一个数据库
	** index唯一
	** 每个index都必须对应一个ServerId(游戏服id)和一个名称(服列表)
	** ServerId可以重复(必须大于0)
	** ----------------------------------------------------------------------------------
	** 增加一个新服:
	** 1.index+1，绑定一个数据库(复制前面的就好了，对应修改数据库地址和用户名密码)
	** 2.绑定一个ServerId(WorldId)
	** 3.绑定一个服名称(显示用)
	*/

	// 获取数据库函数(1)
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

			case 1:
			{
				$conn = mysqli_connect('localhost','root','root');
				mysqli_select_db($conn, '3dmmo');
			}
			break;

			case 2:
			case 3:
			case 4:
			case 5:
			case 6:
			case 7:
			case 8:
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

	// 获取游戏服id(2)
	function GetServerId($index) {
		$serverId = -1;

		switch ($index) {
			case 1:
				$serverId = 100;
				break;

			case 2:
				$serverId = 106;
				break;

			case 3:
				$serverId = 107;
				break;

			case 4:
				$serverId = 108;
				break;

			case 5:
				$serverId = 109;
				break;

			case 6:
				$serverId = 110;
				break;

			case 7:
				$serverId = 111;
				break;

			case 8:
				$serverId = 117;
				break;
			
			default:
				break;
		}

		return $serverId;
	}

	// 服列表(3)
	$serverList = array(
		'本地服0' => array(
			1 => 's100(本地)',
			8 => 's117(内网)', 
			), 
		'本地服1' => array(
			2 => 's106(内网)',
			3 => 's107(内网)', 
			), 
		'本地服2' => array(
			4 => 's108(内网)',
			5 => 's109(内网)', 
			), 
		'本地服3' => array(
			6 => 's110(内网)',
			7 => 's111(内网)', 
			), 
		'本地服4' => array(
			6 => 's110(内网)',
			7 => 's111(内网)', 
			), 
		'本地服5' => array(
			6 => 's110(内网)',
			7 => 's111(内网)', 
			), 
		'本地服6' => array(
			6 => 's110(内网)',
			7 => 's111(内网)', 
			), 
		'本地服7' => array(
			6 => 's110(内网)',
			7 => 's111(内网)', 
			), 
		'本地服8' => array(
			6 => 's110(内网)',
			7 => 's111(内网)', 
			), 
		'本地服9' => array(
			6 => 's110(内网)',
			7 => 's111(内网)', 
			), 
		'本地服10' => array(
			6 => 's110(内网)',
			7 => 's111(内网)', 
			), 
		'本地服11' => array(
			6 => 's110(内网)',
			7 => 's111(内网)', 
			), 
		);
?>
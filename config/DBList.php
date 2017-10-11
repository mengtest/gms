<?php
	/*
	** 可以多个index对应一个数据库
	** index唯一
	** 每个index都必须对应一个ServerId(游戏服id)和一个名称(服列表)
	** ServerId可以重复(必须大于0)
	** ----------------------------------------------------------------------------------
	** 增加一个新服:
	** 1.填写服配置(自增索引)
	** 2.填写服列表(每个服必须有对应的索引,索引必须唯一)
	*/

	// 服配置(1)
	// 0为gm后台数据库配置
	// 1之后为服所在数据库配置
	$serverConfig = array(
		0 => array(
			// 数据库所在地址
			'addr_s' => 'localhost',
			// 数据库用户名
			'user' => 'root',
			// 数据库密码
			'password' => 'root',
			// 数据表名称
			'DataSource' => 'test',
			// 服id(也是游戏的worldid)
			'serverId' => -1,
			),
		1 => array(
			'addr_s' => 'localhost',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => '3dmmo',
			'serverId' => 100,
			),
		2 => array(
			'addr_s' => '192.168.1.117',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => 'mtlbbdb_100',
			'serverId' => 106,
			),
		3 => array(
			'addr_s' => '192.168.1.117',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => 'mtlbbdb_100',
			'serverId' => 107,
			),
		4 => array(
			'addr_s' => '192.168.1.117',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => 'mtlbbdb_100',
			'serverId' => 108,
			),
		5 => array(
			'addr_s' => '192.168.1.117',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => 'mtlbbdb_100',
			'serverId' => 109,
			),
		6 => array(
			'addr_s' => '192.168.1.117',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => 'mtlbbdb_100',
			'serverId' => 110,
			),
		7 => array(
			'addr_s' => '192.168.1.117',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => 'mtlbbdb_100',
			'serverId' => 111,
			),
		8 => array(
			'addr_s' => '192.168.1.117',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => 'mtlbbdb_100',
			'serverId' => 117,
			),
		);

	// 服列表(2)
	// serverList下的key代表平台名
	// 平台下的key为索引,必须与上面服配置匹配
	// 平台下value为服名称(显示用)
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


	/*------------------------------------------------------分割线-------------------------------------------------------*/
	/*--------------------------------------------------以下不需要修改---------------------------------------------------*/

	function GetDBByIndex($index) {
		$conn = null;

		$servercfg = $GLOBALS[serverConfig][$index];
		if ($servercfg && $servercfg['addr_s'] && $servercfg['DataSource']) {
			$conn = mysqli_connect($servercfg['addr_s'], $servercfg['user'], $servercfg['password']);
			mysqli_select_db($conn, $servercfg['DataSource']);
		}

		if ($conn == null) {
			echo 'Could not connect:<br>' . mysqli_error();
		}

		return $conn;
	}

	function GetServerId($index) {
		$serverId = -1;

		$servercfg = $GLOBALS[serverConfig][$index];
		if ($servercfg && $servercfg['addr_s'] && $servercfg['serverId']) {
			$serverId = $servercfg['serverId'];
		}

		return $serverId;
	}
?>
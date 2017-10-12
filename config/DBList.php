<?php
	/*
	** 可以多个index对应一个数据库
	** index唯一
	** 每个index都必须对应一个ServerId(游戏服id)和一个名称(服列表)
	** ServerId可以重复(必须大于0)
	** ----------------------------------------------------------------------------------
	** 增加一个新服:
	** 1.填写服配置(自增索引)
	** 2.如果平台名已存在，最好采用复制的方式，避免出错
	*/

	// 服配置
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
			// 服名称
			'serverName' => 'GM后台',
			// 平台名称
			'platName' => 'GM后台',
			),
		1 => array(
			'addr_s' => 'localhost',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => '3dmmo',
			'serverId' => 100,
			'serverName' => 's100(本地)',
			'platName' => '本地服0',
			),
		2 => array(
			'addr_s' => '192.168.1.117',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => 'mtlbbdb_100',
			'serverId' => 106,
			'serverName' => 's106(内网)',
			'platName' => '本地服1',
			),
		3 => array(
			'addr_s' => '192.168.1.117',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => 'mtlbbdb_100',
			'serverId' => 107,
			'serverName' => 's107(内网)',
			'platName' => '本地服1',
			),
		4 => array(
			'addr_s' => '192.168.1.117',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => 'mtlbbdb_100',
			'serverId' => 108,
			'serverName' => 's108(内网)',
			'platName' => '本地服2',
			),
		5 => array(
			'addr_s' => '192.168.1.117',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => 'mtlbbdb_100',
			'serverId' => 109,
			'serverName' => 's109(内网)',
			'platName' => '本地服2',
			),
		6 => array(
			'addr_s' => '192.168.1.117',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => 'mtlbbdb_100',
			'serverId' => 110,
			'serverName' => 's110(内网)',
			'platName' => '本地服3',
			),
		7 => array(
			'addr_s' => '192.168.1.117',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => 'mtlbbdb_100',
			'serverId' => 111,
			'serverName' => 's111(内网)',
			'platName' => '本地服3',
			),
		8 => array(
			'addr_s' => '192.168.1.117',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => 'mtlbbdb_100',
			'serverId' => 117,
			'serverName' => 's117(内网)',
			'platName' => '本地服0',
			),
		9 => array(
			'addr_s' => '192.168.1.117',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => 'mtlbbdb_100',
			'serverId' => 110,
			'serverName' => 's110(内网)',
			'platName' => '本地服4',
			),
		10 => array(
			'addr_s' => '192.168.1.117',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => 'mtlbbdb_100',
			'serverId' => 111,
			'serverName' => 's111(内网)',
			'platName' => '本地服4',
			),
		11 => array(
			'addr_s' => '192.168.1.117',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => 'mtlbbdb_100',
			'serverId' => 110,
			'serverName' => 's110(内网)',
			'platName' => '本地服5',
			),
		12 => array(
			'addr_s' => '192.168.1.117',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => 'mtlbbdb_100',
			'serverId' => 111,
			'serverName' => 's111(内网)',
			'platName' => '本地服5',
			),
		13 => array(
			'addr_s' => '192.168.1.117',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => 'mtlbbdb_100',
			'serverId' => 110,
			'serverName' => 's110(内网)',
			'platName' => '本地服6',
			),
		14 => array(
			'addr_s' => '192.168.1.117',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => 'mtlbbdb_100',
			'serverId' => 111,
			'serverName' => 's111(内网)',
			'platName' => '本地服6',
			),
		15 => array(
			'addr_s' => '192.168.1.117',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => 'mtlbbdb_100',
			'serverId' => 110,
			'serverName' => 's110(内网)',
			'platName' => '本地服7',
			),
		16 => array(
			'addr_s' => '192.168.1.117',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => 'mtlbbdb_100',
			'serverId' => 111,
			'serverName' => 's111(内网)',
			'platName' => '本地服8',
			),
		17 => array(
			'addr_s' => '192.168.1.117',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => 'mtlbbdb_100',
			'serverId' => 110,
			'serverName' => 's110(内网)',
			'platName' => '本地服9',
			),
		18 => array(
			'addr_s' => '192.168.1.117',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => 'mtlbbdb_100',
			'serverId' => 111,
			'serverName' => 's111(内网)',
			'platName' => '本地服10',
			),
		19 => array(
			'addr_s' => '192.168.1.117',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => 'mtlbbdb_100',
			'serverId' => 110,
			'serverName' => 's110(内网)',
			'platName' => '本地服11',
			),
		20 => array(
			'addr_s' => '192.168.1.117',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => 'mtlbbdb_100',
			'serverId' => 111,
			'serverName' => 's111(内网)',
			'platName' => '本地服12',
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

	function GetServerList() {
		$tempServerList = array();
		$servercfg = $GLOBALS[serverConfig];

		// 把配置扫描进去
		foreach ($servercfg as $index => $serverInfo) {
			if ($index <= 0) continue;

			if (empty($tempServerList[$serverInfo[platName]])) {
				// 新增一个平台
				$platInfo = array($index => $serverInfo[serverName]);
				$tempServerList[$serverInfo[platName]] = $platInfo;
			}
			else {
				// 平台已存在
				$tempPlatInfo = $tempServerList[$serverInfo[platName]];
				if (empty($tempPlatInfo[$index])) {
					$tempPlatInfo[$index] = $serverInfo[serverName];
				}
				$tempServerList[$serverInfo[platName]] = $tempPlatInfo;
			}
		}

		return $tempServerList;
	}
?>
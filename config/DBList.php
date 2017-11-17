<?php
	// 定义本地数据库信息
	$local_db = array(
			// 数据库所在地址
			'addr_s' => 'localhost',
			// 数据库用户名
			'user' => 'root',
			// 数据库密码
			'password' => 'root',
			// 数据源名称
			'DataSource' => 'test',
			);

	/*------------------------------------------------------分割线-------------------------------------------------------*/
	/*--------------------------------------------------以下不需要修改---------------------------------------------------*/

	// 服配置(从1开始)
	/*$serverConfig2 = array(
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
		21 => array(
			'addr_s' => '192.168.1.117',
			'user' => 'root',
			'password' => 'root',
			'DataSource' => 'mtlbbdb_100',
			'serverId' => 101,
			'serverName' => 's101(内网)',
			'platName' => '本地服13',
			),
		);*/

	/*------------------------------------------------------分割线-------------------------------------------------------*/
	/*--------------------------------------------------以下不需要修改---------------------------------------------------*/

	if (empty($serverConfig) || empty($serverList)) {
		$serverConfig = array();
		LoadServerConfig();
	}

	function LoadServerConfig() {
		if (!empty($GLOBALS[serverConfig])) {
			return;
		}

		array_push($GLOBALS[serverConfig], $GLOBALS[local_db]);

		$tempServerList = array();
		$connload0 = GetDBByIndex(0);
		if ($connload0) {
			$sql = "select * from server_info";
			$query = mysqli_query($connload0, $sql);

			$index = 1;
			while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
				$serverInfo = array(
					'addr_s' => $row[addrs],
					'user' => $row[duser],
					'password' => $row[dpassword],
					'DataSource' => $row[datasource],
					'DataSource_log' => $row[datasource_log],
					'platName' => $row[platname],
					'serverName' => $row[servername],
					'serverId' => $row[serverid],
					);

				array_push($GLOBALS[serverConfig], $serverInfo);

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

				$index++;
			}
		}

		/*foreach ($GLOBALS[serverConfig2] as $index => $serverInfo) {
			array_push($GLOBALS[serverConfig], $serverInfo);

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
		}*/

		// 每次重新读取,保持一致性
		$GLOBALS[serverList] = $tempServerList;
	}

	function ReLoadServerConfig() {
		$GLOBALS[serverConfig] = array();
		LoadServerConfig();
	}

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

		// 设置数据库编码
		mysqli_query($conn,'set names utf8');

		return $conn;
	}

	function GetLogDBByIndex($index) {
		$conn = null;

		$servercfg = $GLOBALS[serverConfig][$index];
		if ($servercfg && $servercfg['addr_s'] && $servercfg['DataSource_log']) {
			$conn = mysqli_connect($servercfg['addr_s'], $servercfg['user'], $servercfg['password']);
			mysqli_select_db($conn, $servercfg['DataSource_log']);
		}

		if ($conn == null) {
			echo 'Could not connect:<br>' . mysqli_error();
		}

		// 设置数据库编码
		mysqli_query($conn,'set names utf8');

		return $conn;
	}

	function GetServerId($index) {
		$serverId = -1;

		if ($index <= 0) return -1;

		$servercfg = $GLOBALS[serverConfig][$index];
		if ($servercfg && $servercfg['addr_s'] && $servercfg['serverId']) {
			$serverId = $servercfg['serverId'];
		}

		return $serverId;
	}

	function GetDBInfo($index, $key) {
		$rVal = '';

		if ($index <= 0) return '';

		$servercfg = $GLOBALS[serverConfig][$index];
		if ($servercfg && $servercfg['addr_s'] && $servercfg['platName'] && $servercfg[$key]) {
			$rVal = $servercfg[$key];
		}

		return $rVal;
	}

	function GetDBAddrs($index) {
		$db_addrs = '';

		$servercfg = $GLOBALS[serverConfig][$index];
		if ($servercfg && $servercfg['addr_s']) {
			$db_addrs = $servercfg['addr_s'];
		}

		return $db_addrs;
	}

	function GetDBSource($index) {
		$db_source = '';

		$servercfg = $GLOBALS[serverConfig][$index];
		if ($servercfg && $servercfg['addr_s'] && $servercfg['DataSource']) {
			$db_source = $servercfg['DataSource'];
		}

		return $db_source;
	}

	function GetLogDBSource($index) {
		$db_source = '';

		$servercfg = $GLOBALS[serverConfig][$index];
		if ($servercfg && $servercfg['addr_s'] && $servercfg['DataSource_log']) {
			$db_source = $servercfg['DataSource_log'];
		}

		return $db_source;
	}
?>
<?php
	$absolute_path = dirname(dirname(__FILE__));

	require_once("$absolute_path/config/DBList.php");

	function OnRecordOption($userName, $option, $serverindex, $player) {
		// 这里不检测了，直接记录
		$conn = GetDBByIndex(0);
		if ($conn == null) {
			exit();
		}

		$conn1 = GetDBByIndex($serverindex);
		if ($conn1 == null) {
			// 所选服不存在
			exit("所选服不存在");
		}

		$server = GetServerId($serverindex);
		if ($server <= 0) {
			exit("所选服id不存在");
		}

		$serverInfo = '';
		foreach ($GLOBALS[serverList] as $plat => $serverListInfo) {
			$finish = false;
			foreach ($serverListInfo as $index => $serverName) {
				if ($serverindex == $index) {
					$serverInfo = $plat."-".$serverName;
					$finish = true;
					break;
				}
			}

			if ($finish)
				break;
		}

		$time = date("Y/m/d h:i:sa");

		$sql = "insert into option_record(username, `option`, optionserver, player, time) value('$userName', '$option', '$serverInfo', '$player', '$time')";
		mysqli_query($conn, $sql);
	}

	function OnRecordOptionGuid($userName, $option, $serverindex, $guid) {
		$conn = GetDBByIndex(0);
		if ($conn == null) {
			exit();
		}

		$conn1 = GetDBByIndex($serverindex);
		if ($conn1 == null) {
			// 所选服不存在
			exit("所选服不存在");
		}

		$server = GetServerId($serverindex);
		if ($server <= 0) {
			exit("所选服id不存在");
		}

		$sql1 = "select * from charfulldata where guid = '$guid'";
		$query = mysqli_query($conn1, $sql1);
		$row = mysqli_fetch_array($query);
		if ($row == null) {
			// 操作角色不存在
			exit("操作角色不存在");
		}

		$player = $row[charname];

		$serverInfo = '';
		foreach ($GLOBALS[serverList] as $plat => $serverListInfo) {
			$finish = false;
			foreach ($serverListInfo as $index => $serverName) {
				if ($serverindex == $index) {
					$serverInfo = $plat."-".$serverName;
					$finish = true;
					break;
				}
			}

			if ($finish)
				break;
		}

		$time = date("Y/m/d h:i:sa");

		$sql2 = "insert into option_record(username, `option`, optionserver, player, time) value('$userName', '$option', '$serverInfo', '$player', '$time')";
		mysqli_query($conn, $sql2);
	}

	function OnRecordOptionAll($userName, $option, $player, $serverInfo) {
		// 这里不检测了，直接记录
		$conn = GetDBByIndex(0);
		if ($conn == null) {
			exit();
		}

		$time = date("Y/m/d h:i:sa");

		$sql = "insert into option_record(username, `option`, optionserver, player, time) value('$userName', '$option', '$serverInfo', '$player', '$time')";
		mysqli_query($conn, $sql);
	}
?>
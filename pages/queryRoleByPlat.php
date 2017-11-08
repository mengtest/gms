<?php
	$ResInfo = array(
		'count' => 0,
		'data' => array(),
		);
	if ($_GET['plat'] == '' || $_GET['plat'] == null ||
		$_GET['accname'] == '' || $_GET['accname'] == null) {
		echo json_encode($ResInfo);
		exit();
	}

	require_once("../config/CommomConfig.php");
	require_once("../config/DBList.php");

	function AddResInfo($serverId, $name, $prof, $level) {
		$tempInfo = array(
			'sId' => $serverId,
			'name' => $name,
			'prof' => $prof,
			'level' => $level
			);
		array_push($GLOBALS[ResInfo]['data'], $tempInfo);
		$GLOBALS[ResInfo]['count'] += 1;
	}

	foreach ($serverConfig as $index => $value) {
		if ($value['platName'] == $_GET['plat']) {
			$conn = GetDBByIndex($index);
			$serverId = GetServerId($index);
			if ($conn != null && $serverId > 0) {
				$sql = "select * from charfulldata where worldid = $serverId and accname = '$_GET[accname]' and deletetime = 0";
				$query = mysqli_query($conn, $sql);
				while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
					AddResInfo($serverId, $row[charname], $row[profession], $row[level]);
				}
			}
		}
	}

	echo json_encode($ResInfo, JSON_UNESCAPED_UNICODE);
?>
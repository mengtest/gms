<?php
	$absolute_path = dirname(dirname(__FILE__));

	require_once("$absolute_path/config/CommomConfig.php");
	require_once("$absolute_path/config/DBList.php");
	require_once("$absolute_path/config/FileJurisdiction.php");

	function JurisdictionCheck($file, $uid) {
		// 设置一个默认权限
		$jurisdiction = -1;

		if ($uid == null) {
			return 1;
		}
		else {
			// 检测Session信息
			$sql = "select * from user_list where `uid` = '$uid'";
			$Dbc = GetDBByIndex(0);

			if ($Dbc == null) {
				//exit();
				echo "db 为空";
				return 2;
			}
			else {
				$query = mysqli_query($Dbc, $sql);
				$row = mysqli_fetch_array($query);

				if ($row == null) {
					return 1;
				}
				else {
					// 检测结果
					if (is_array($row)) {
						$jurisdiction = $row[jurisdiction];
					}
					else {
						return 1;
					}
				}
			}
		}

		$needJur = GetJurisdiction($file);
		if ($needJur >= 0 && $jurisdiction > $needJur) {
			return 3;
		}

		return 0;
	}
?>
<?php
	/*
	** PHP权限限制
	** 不配置代表无限制
	** 值越小，需要的权限越大(0为管理员可用)
	** 创建角色,修改角色密码等操作只有0权限可用
	 */
	function GetJurisdiction($file) {
		$jurisdiction = -1;

		switch ($file) {
			case 'GMCommand.php':
				$jurisdiction = 0;
				break;

			case 'queryPlayer.php':
				$jurisdiction = 1;
				break;

			case 'record.php':
				$jurisdiction = 2;
				break;

			case 'sendItem.php':
				$jurisdiction = 0;
				break;
			
			default:
				break;
		}

		return $jurisdiction;
	}
?>
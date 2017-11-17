<?php
	/*
	** PHP权限限制
	** 不配置代表无限制
	** 值越小，需要的权限越大(0为管理员可用)
	** 创建角色,修改角色密码等操作只有0权限可用(已写死)
	 */
	function GetJurisdiction($file) {
		$jurisdiction = -1;

		switch ($file) {
			// GM命令
			case 'GMCommand.php':
				$jurisdiction = 0;
				break;

			// 查询角色
			case 'queryPlayer.php':
				$jurisdiction = 1;
				break;

			// 操作记录
			case 'record.php':
				$jurisdiction = 2;
				break;

			// 发送物品
			case 'sendItem.php':
				$jurisdiction = 0;
				break;

			// 系统通告
			case 'systemNotice.php':
				$jurisdiction = 2;
				break;

			// 发送邮件
			case 'sendMail.php':
				$jurisdiction = 0;
				break;

			// 角色管理
			case 'playerManager.php':
				$jurisdiction = 0;
				break;

			// 机器人管理
			case 'robotManager.php':
				$jurisdiction = 0;
				break;

			// 平台管理
			case 'platManager.php':
				$jurisdiction = 0;
				break;

			// 道具记录(个人)
			case 'itemRecordPerson.php':
				$jurisdiction = 0;
				break;

			// 道具记录(全服)
			case 'itemRecordAll.php':
				$jurisdiction = 0;
				break;

			// 道具记录(来源)
			case 'itemRecordSource.php':
				$jurisdiction = 0;
				break;

			// 玩家操作记录
			case 'playerRecord.php':
				$jurisdiction = 0;
				break;
			
			default:
				break;
		}

		return $jurisdiction;
	}
?>
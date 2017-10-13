<?php
	$Title = "这里是发送邮件页";
	require_once("../html/header.html");
	echo "<div class = 'shade_div2'></div>";
	require_once("../config/menu.php");

	// 检测登陆状态
	require_once("../script/check.php");
	$checkVal = JurisdictionCheck(basename($_SERVER["PHP_SELF"]), $_SESSION[uid]);
	if ($checkVal != 0) {
		echo "<script language=javascript>alert('$error_notice[$checkVal]');history.back();</script>";
	}

	require_once("../config/DBList.php");
	require_once("../script/selectserver.php");
	require_once("../config/CommomConfig.php");
	require_once("../script/optionrecord.php");
?>

<hr class = 'mail_hr' />

<div class = 'mail_div'>
	<form action = '' method = 'post'>
		<table width="100%">
		<tr>
			<th align="left">
				平台列表：<select name='mail_some_plat'>
					<option value = '0'>上面选择的服(单服)</option>
					<option value = '1'>全平台</option>
					<?php
						$i = 2;
						foreach ($serverList as $plat => $idList) {
							echo "<option value = '$i'>$plat</option>";
							$i++;
						}
					?>
				</select>
			</th>
			<th>
				vip等级：<select name='mail_some_vip'>
					<?php
						for ($j = 0; $j < vip_max; $j++) {
							$vip_show = 'vip'.$j.'以上';
							echo "<option value = '$j'>$vip_show</option>";
						}
					?>
				</select>
			</th>
			<th>
				角色等级：<input name="player_level" type="text" value="0" style="width:30px" />级以上
			</th>
		</tr>
		</table><br/><br/>
		<div>
			(多个玩家名,可用' '隔开,不填为全服玩家)<br/>
			玩家名：<input name="player_name" type="text" style="width:30%" /><br/><br/>
			(多个物品,可用','隔开,格式:id,num,isBind,id,num,isBind)<br/>
			物品组：<input name="items" type="text" style="height:50px; width:83%" /><br/><br/>
			<table width="100%">
			<tr>
				<td align="left">
					灵玉：&nbsp;<input name="lingyu" type="text" value="0"/>
				</td>
				<td>
					元宝：<input name="yuanbao" type="text" value="0"/>
				</td>
				<td>
					银两：<input name="yinliang" type="text" value="0"/>
				</td>
			</tr>
			</table><br/><br/>
			<!--邮件主题：<input name="account" type="text" style="width:30%" /><br/><br/>-->
			邮件内容：<input name="mail_content" type="text" style="height:50px; width:30%" /><br/><br/>
		</div>
		<div align = "center">
			<input name = 'submitmail' type = 'submit' value = '发送邮件' />
		</div>
	</form>
</div>

<?php
	function SendMail($server_index, $vip, $level, $mcontent, $mitem, $myinliang, $mlingyu, $myuanbao, $myinpiao, $time) {
		$conns = GetDBByIndex($server_index);
		$serverId = GetServerId($server_index);
		if ($conns && $serverId > 0) {
			$sqls = "insert into gmcommand(worldid, type, command, param) values('$serverId', '6', 'gmmail,".$mcontent.",".$time.",".$myinliang.",".$mlingyu.",".$myuanbao.",".$myinpiao;

			if ($mitem) {
				$sqls .= ",$mitem', '".$vip.",".$level."')";
			}
			else {
				$sqls .= "', '".$vip.",".$level."')";
			}

			mysqli_query($conns, $sqls);
		}
	}

	if ($_POST[submitmail]) {
		if ($_POST[mail_content] == null) {
			alertMsg("请先输入邮件内容");
		}
		else {
			$record_info = '物品组:'.$_POST[items].'-灵玉:'.$_POST[lingyu].',元宝:'.$_POST[yuanbao].',银两:'.$_POST[yinliang].'-内容:'.$_POST[mail_content];
			$time = time();

			if ($_POST[mail_some_plat] > 0) {
				// 这里是选择了平台的(全服邮件)
				if (!is_numeric($_POST[player_level])) {
					alertMsg("等级必须为纯数字");
				}
				else {
					$i = ($_POST[mail_some_plat] == 1) ? -1 : 2;
					foreach ($serverList as $plat => $idList) {
						if ($i < 0 || $_POST[mail_some_plat] == $i) {
							foreach ($idList as $server_index => $servername) {
								SendMail($server_index, $_POST[mail_some_vip], $_POST[player_level], $_POST[mail_content], $_POST[items], $_POST[yinliang], $_POST[lingyu], $_POST[yuanbao], 0, $time);
							}

							if ($i > 0) {
								OnRecordOptionAll($_SESSION[name], '单平台邮件-'.$record_info, $plat.'该平台所有玩家', $plat.'该平台所有服');
								break;
							}
						}

						if ($i > 0)
							$i++;
					}

					if ($i == -1) {
						OnRecordOptionAll($_SESSION[name], '全平台邮件-'.$record_info, '所有玩家', '所有平台');
					}
				}
			}
			else {
				// 这里是发给单服玩家
				$conn1 = GetDBByIndex($_SESSION[DBIndex]);
				$serverId = GetServerId($_SESSION[DBIndex]);
				if ($conn1 == null || $_SESSION[DBIndex] <= 0 || $serverId <= 0) {
					alertMsg("请先选择服再操作");
				}
				else {
					if ($_POST[player_name] == null) {
						// 发送给全服玩家
						SendMail($_SESSION[DBIndex], $_POST[mail_some_vip], $_POST[player_level], $_POST[mail_content], $_POST[items], $_POST[yinliang], $_POST[lingyu], $_POST[yuanbao], 0, $time);

						OnRecordOptionAll($_SESSION[name], '单服邮件-'.$record_info, '该服所有玩家', $_SESSION[platName]."-".$serverList[$_SESSION[platName]][$_SESSION[DBIndex]]);
					}
					else {
						$plat_list = explode(" ", $_POST[player_name]);
						$sql1 = "insert into gmcommand(worldid, type, command, param) values";
						$sqlinc = "('$serverId', '2', 'gmmail,".$_POST[mail_content].",".$time.",".$_POST[yinliang].",".$_POST[lingyu].",".$_POST[yuanbao].",0";
						if ($_POST[items]) {
							$sqlinc .= ",$_POST[items]', ";
						}
						else {
							$sqlinc .= "', ";
						}

						for ($i = 0; $i < count($plat_list); $i++) {
							if ($i > 0) {
								$sql1 = $sql1.','.$sqlinc."'".$plat_list[$i]."')";
							}
							else {
								$sql1 = $sql1.$sqlinc."'".$plat_list[$i]."')";
							}
						}

						mysqli_query($conn1, $sql1);

						OnRecordOption($_SESSION[name], '发送邮件-'.$record_info, $_SESSION[DBIndex], $_POST[player_name]);
					}
				}
			}
		}
	}

	$conn = GetDBByIndex(0);
	$option_table = 'mail_record';
	$sql = "select * from option_record where `option` like '单平台邮件-%' or `option` like '发送邮件-%' or `option` like '单服邮件-%' or `option` like '全平台邮件-%' order by id desc";
	require_once("../script/optionTable.php");

	require_once("../html/bottom.html");
?>
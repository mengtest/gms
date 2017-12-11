<?php
	// 日志描述解析
	function GetLogDescribe($logType, $type, $param1 = '', $param2 = '', $param3 = '', $param4 = '', $param5 = '', $param6 = '', $param7 = '', $param8 = '', $param9 = '', $param10 = '', $param11 = '', $param12 = '', $param13 = '', $param14 = '', $param15 = '') {
		$Describe = "(".$type.")";

		$ConsumeType = array(
			0 => "银两",
			1 => "灵玉",
			2 => "元宝",
			3 => "银票",
			4 => "玩家挑战积分",
			5 => "夺宝积分",
		);

		/*--------------------------
		** logType
		** 1 => itemlog
		** 2 => momeylog
		** 3 => commonlog
		 --------------------------*/

		switch ($type) {
			case 70:
				{
					switch ($logType) {
						case 1:
							//$Describe = "在易市花费".$param3.$ConsumeType[$param4]."购买了".$param2."个".$param3;
							break;

						case 2:
							$Describe = "在易市花费".(-$param5).$ConsumeType[$param4]."购买了".$param2."个".$param3;
							break;

						case 3:
							$Describe = "在易市花费".$param4.$ConsumeType[$param3]."购买了".$param2."个".$param1;
							break;
						
						default:
							# code...
							break;
					}
				}
				break;

			case 104:
				{
					$Describe = "在门派挑战花费".$param4.$ConsumeType[$param3]."购买了".$param2."个".$param1;
				}
				break;

			case 105:
				{
					$Describe = "在夺宝积分花费".$param4.$ConsumeType[$param3]."购买了".$param2."个".$param1;
				}
				break;

			case 10061:
				{
					$Describe = "获得 $param5 $ConsumeType[$param4]";
				}
				break;

			case 20009:
				{
					$Describe = "宠物技能type:20009,".$param1.":消耗物品id， $param2 ：消耗物品数量， $param3 ：消耗金钱类型，$param4 ：消耗金钱数量， $param5 ：学习技能，$param6 ：学籍技能等级，$param7 ：学籍后的技能id， $param8：学习后技能等级";
				}
				break;

			case 30013:
				{
					$Describe = "type:30013, $param1 :消耗物品id，$param2 :消耗物品数量，$param3 :体质资质，$param4 :精力资质，$param5 :力量资质，$param6 :智力资质，$param7 :敏捷资质，$param8 :成长";
				}
				break;

			case 30014:
				{
					$Describe = "type：30014，  $param1 ：消耗物品id， $param2 ：消耗物数量，$param6 :提升之前的悟性，$param7 :提升之后悟性";
				}
				break;

			case 30015:
				{
					$Describe = "type:30015,  $param1 :消耗物品id，intparam：消耗物品数量，$param3 ：提升前修为，$param4 ：提升后修为";
				}
				break;

			case 40003:
				{
					$Describe = "type：40063（夺宝成功），type：40062（夺宝失败）， $param1 ：投入的金钱类型，$param2 ：投入的金钱数量， $param3 ：夺宝开奖返回物品id，$param4 ：夺宝开奖返回的物品数量， $param5 ：夺宝开奖返回的金钱类型，$param6 ：夺宝开奖返回的金钱数量（有可能单独返回物品或者金钱，为零）";
				}
				break;

			case 60100:
				{
					$Describe = "type：60100， $param1 ：消耗物品id， $param2 ：物品数量， $param3 : 使用之前等级 $param4 :使用之后等级";
				}
				break;

			case 60101:
				{
					$Describe = "type：60101， $param1 :消耗物品id，$param2 :消耗物品数量，$param3 :使用之前的寿命，$param4 :使用之后的寿命";
				}
				break;

			case 60102:
				{
					$Describe = "type：60102， $param1 ：消耗物品id， $param2 ：消耗物品数量，$param3 ：消耗金钱类型，$param4 ：消耗金钱数量，$param11 ：学习后技能汇总（skillid1，skillid2......）";
				}
				break;
			
			default:
				$Describe = "未定义描述".$Describe;
				break;
		}

		return $Describe;
	}
?>
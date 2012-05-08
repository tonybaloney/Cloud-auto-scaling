<?php

class Log {
	public static function GetLogs($uid=false) {
		if(!$uid) $uid = Auth::GetUID();
		return DB::GetData("SELECT `log`.*,`triggers`.triggerName,`clusters`.`clusterName` FROM `log` INNER JOIN `triggers` ON `triggers`.`triggerId`=`log`.`triggerId` INNER JOIN `clusters` ON `clusters`.`clusterId`=`log`.`clusterId` WHERE `log`.`customerId` = $uid");
	}
}
?>
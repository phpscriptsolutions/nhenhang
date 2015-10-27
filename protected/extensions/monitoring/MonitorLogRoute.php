<?php
class MonitorLogRoute extends CLogRoute {
	/**
	 *
	 * @param array $logs
	 * string	[0]	- message
	 * string	[1]	- level
	 * string	[2]	- category
	 * float	[3]	- timestamp
	 */
	protected function processLogs($logs)
	{
		foreach($logs as $log) {
			/* $loger = new KLogger("SENTRY_LOG", KLogger::INFO);
			$loger->LogError($_SERVER["REMOTE_ADDR"].$log[0]); */
			Yii::app()->monitoring->captureMessage($log[0], $log[1], $log[2]);
		}
	}
}
?>

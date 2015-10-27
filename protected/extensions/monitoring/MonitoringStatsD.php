<?php
class MonitoringStatsD extends CApplicationComponent {
	public $config;
	private $_client = null;

	/**
     * init function
     */
    public function init()
    {
		parent::init();
    }

    /**
     * Main extension loader
     * @param array $config - configuration array
     * @return Monitoring Instance
     */
    public function getClient()
    {
        if($this->_client === null) {
			require_once(dirname(__FILE__) . '/StatsD/Client.php');

			Yii::log("Load StatsD Client", "trace");
			$this->_client = new \StatsD\Client($this->config['host']);
		}

		return $this->_client;
	}
}
?>

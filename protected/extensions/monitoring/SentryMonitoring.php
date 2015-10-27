<?php
class SentryMonitoring {
	public $apiKey = 'http://ea4cdbb7136a443a9ecdbcd383b19d13:ca26b218d2e642ea9f2490b91a76d7bb@sentry/2';
	private $_client;

	public function captureMessage($message, $level, $category) {
		if($message) {
			$client = $this->_getClient();
			$event_id = $client->getIdent($client->captureMessage($message, array(), array('level' => $level, 'logger' => $category)));

			return $event_id;
		}
		return 0;
	}

	public function captureException($e) {
		$client = $this->_getClient();
		$event_id = $client->getIdent($client->captureException($e));
		return $event_id;
	}

	//PRIVATE FUNCTION
	private function _getClient() {
		if($this->_client === null) {
			require(dirname(__FILE__) . '/Raven/Autoloader.php');
			Raven_Autoloader::register();
			$this->_client = new Raven_Client($this->apiKey);
		}

		return $this->_client;
	}
}
?>

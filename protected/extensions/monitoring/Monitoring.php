<?php
class Monitoring extends CApplicationComponent {
	public $engine;
	public $config;
	public $debug = false;

	private $_monitoring;

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
    public function load()
    {
        if($this->_monitoring === null){
			require_once(dirname(__FILE__) . '/'.$this->engine.'.php');

			$this->_monitoring = new $this->engine;

			if(!empty($this->config))
            {
                foreach ($this->config as $key => $val)
                {
                    $this->_monitoring->$key = $val;
                }
            }
		}

		return $this->_monitoring;
	}

	/**
	 *
	 * Log message to monitoring server
	 * @param string $message
	 * @param type $level
	 * @param type $category
	 */
	public function captureMessage($message, $level, $category) {
		$debug = $this->debug;
		// Chi bat che do debug khi Yii khong bat debug
		if(YII_DEBUG && YII_TRACE_LEVEL>0 && $level!==CLogger::LEVEL_PROFILE)
		{
			$debug = false;
		}

		if($debug && YII_TRACE_LEVEL>0) {
			$traces=debug_backtrace();
			$count=0;
			foreach($traces as $trace)
			{
				if(isset($trace['file'],$trace['line']) && strpos($trace['file'],YII_PATH)!==0)
				{
					$message.="\nin ".$trace['file'].' ('.$trace['line'].')';
					if(++$count>=YII_TRACE_LEVEL)
						break;
				}
			}
		}

		return $this->load()->captureMessage($message, $level, $category);
	}

	public function captureException($e) {
		return $this->load()->captureException($e);
	}
}

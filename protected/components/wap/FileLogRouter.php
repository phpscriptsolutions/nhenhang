<?php
class FileLogRouter extends CFileLogRoute {
	public function init()
	{
		$path  = _APP_PATH_.DS."protected".DS."runtime".DS."wap";
		if(!file_exists($path)){
			@mkdir($path, 0777, true);		
		}
		
		if($this->getLogPath()===null)
		$this->setLogPath($path);
		parent::init();
	}
	
}
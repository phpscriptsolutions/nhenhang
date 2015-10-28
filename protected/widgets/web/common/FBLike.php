<?php
class FBLike extends CWidget{
	public $url = "http://nhac.vn";
	public $name;
	
	public function init(){}
	public function run(){
		$this->render("FBLike", array(
			"url" => $this->url,
			"name" => $this->name
		));
	}
} 
?>
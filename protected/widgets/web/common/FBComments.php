<?php
class FBComments extends CWidget{
	public $url = "nhenhang.com";
	
	public function init(){}
	public function run(){
		echo '';
		 $this->render("fbComments", array(
			"url"	=> $this->url
		));
	}
}
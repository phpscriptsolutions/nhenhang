<?php
class FBComments extends CWidget{
	public $url = "nhac.vn";
	
	public function init(){}
	public function run(){
		echo '';
		 $this->render("fbComments", array(
			"url"	=> $this->url
		));
	}
}
<?php
class SocialShares extends CWidget{
	public $url = 'nhac.vn';
	public $name;
	public $imgsrc;
	public $title;
	public function run(){
		$this->render("socialShare");
	}
}
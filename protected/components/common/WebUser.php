<?php
class WebUser extends CWebUser
{
	public function init()
	{
		/* $conf = Yii::app()->session->cookieParams;
		$this->identityCookie = array(
            'path' => "/",
            'domain' => "192.168.42.89",
		); */
		parent::init();
	}
}
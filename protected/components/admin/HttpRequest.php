<?php
class HttpRequest extends CHttpRequest
{
	private $_csrfToken;

	public function getCsrfToken()
	{
		if($this->_csrfToken===null)
		{
			$session = Yii::app()->session;
			$csrfToken=$session->itemAt($this->csrfTokenName);
			if($csrfToken===null)
			{
				$csrfToken = sha1(uniqid(mt_rand(),true));
				$session->add($this->csrfTokenName, $csrfToken);
			}
			$this->_csrfToken = $csrfToken;
		}

		return $this->_csrfToken;
	}
	public function validateCsrfToken($event)
	{
		if($this->getIsPostRequest())
		{
			$query = $this->getQueryString();
			if($this->getIsAjaxRequest() && strpos($query, 'delete')===false){
				//action load by ajax type=post is valid
			}else{
				// only validate POST requests
				$session=Yii::app()->session;
				if($session->contains($this->csrfTokenName) && isset($_POST[$this->csrfTokenName]))
				{
					$tokenFromSession=$session->itemAt($this->csrfTokenName);
					$tokenFromPost=$_POST[$this->csrfTokenName];
					$valid=$tokenFromSession===$tokenFromPost;
				}
				else
				$valid=false;
				if(!$valid)
					throw new CHttpException(400,Yii::t('yii','The CSRF token could not be verified.'));
			}
		}
	}
}
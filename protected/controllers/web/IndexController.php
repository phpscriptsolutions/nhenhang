<?php
class IndexController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionError()
	{
		$this->layout = 'application.views.web.layouts.main';
		$error = Yii::app()->errorHandler->error;
		$this->render('error', array('error'=>$error) );
	}

	public function actionLoadJs()
	{
		$path = Yii::getPathOfAlias('application.messages').DS.Yii::app()->language.DS."js.php";
		$data = array();
		if(file_exists($path)){
			$data = require_once $path;
		}
		$this->renderPartial("loadJs",compact("data"));
	}
    public function actionAllInOne()
    {
        $type = Yii::app()->request->getParam('type');
        $url_key = Yii::app()->request->getParam('url_key');
        $idx = Yii::app()->request->getParam('idx');
        $id = Yii::app()->request->getParam('id');
        $validType = array('album','playlist');
        if(!in_array($type,$validType)){
            $type='song';
        }
        echo 'type:'.$type.'<br />';
        echo 'url_key:'.$url_key.'<br />';
        echo 'content Id:'.$idx.'<br />';
        echo 'content Id:'.$id.'<br />';
        exit;
    }
}

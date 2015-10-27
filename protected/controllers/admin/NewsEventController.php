<?php
Yii::import("ext.xupload.models.XUploadForm");
class NewsEventController extends Controller
{

	public $channel = "wap";
	public $uploadModel;
    public function init()
	{
		parent::init();
        $this->pageTitle = Yii::t('admin', "Quản lý  News Event") ;
        if (isset($_SESSION['channel'])){
        	$this->channel = $_SESSION['channel'];
        }
	}

	public function actions()
	{
		return array(
				'upload'=>array(
						'class'=>'ext.xupload.actions.XUploadAction',
						'subfolderVar' => 'parent_id',
						'path' => '',
						'alowType'=>'image/jpeg,image/png,image/gif,image/x-png,image/pjpeg'
				),
		);
	}


	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
        $pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize',$pageSize);

		$model=new AdminNewsEventModel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AdminNewsEventModel']))
			$model->attributes=$_GET['AdminNewsEventModel'];
		
		$this->render('index',array(
			'model'=>$model,
            'pageSize'=>$pageSize
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new AdminNewsEventModel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        $error=0;
		if(isset($_POST['AdminNewsEventModel']))
		{
			$model->attributes=$_POST['AdminNewsEventModel'];
			$model->created_time = new CDbExpression("NOW()");
            if(isset($_POST['channels'])){
                $channel = implode(',',$_POST['channels']);
                $model->channel = $channel;
            }
            $fileAvatar = Yii::app()->params['storage']['baseStorage'].DS."tmp".DS.$_POST['source_image_path'];
            if(!file_exists($fileAvatar)){
            	$model->addError("file", "Chưa upload ảnh");
            }else{
                //check allow widthxheight
                $imgSize = getimagesize($fileAvatar);
                $maxW = '860';
                $maxH = '312';
                $realW = $imgSize[0];
                $realH = $imgSize[1];
                if ($realW > $maxW || $realH > $maxH) {
                    $error =1;
                    $model->addError("file", "Kích thước ảnh không chính xác");
                }
                if($error==0) {
                    if ($model->save()) {
                        $this->createImage($model, $fileAvatar);
                        $this->redirect(array('view', 'id' => $model->id));
                    }
                }
            }

		}
		$this->uploadModel =  new XUploadForm();
		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AdminNewsEventModel']))
		{
			$model->attributes=$_POST['AdminNewsEventModel'];
            if(isset($_POST['channels'])){
                $channel = implode(',',$_POST['channels']);
                $model->channel = $channel;
            }
            $error=0;
            //check allow widthxheight
            $fileAvatar = Yii::app()->params['storage']['baseStorage'].DS."tmp".DS.$_POST['source_image_path'];
			if($model->save()){
				if(file_exists($fileAvatar)){
					$imgSize = getimagesize($fileAvatar);
					$maxW = '860';
					$maxH = '312';
					$realW = $imgSize[0];
					$realH = $imgSize[1];
					if ($realW >= $maxW && $realH >= $maxH) {
						$this->createImage($model, $fileAvatar);
					}
				}
				$this->redirect(array('view','id'=>$model->id));
			}

		}

		$this->uploadModel =  new XUploadForm();
		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

    public function actionReorder(){
        $data = Yii::app()->request->getParam('sorder');
        //$data = ArrayHelper::reorder($data);
        $maxArray = max($data);

        /* $c = new CDbCriteria();
	    $c->order = "sorder ASC, id DESC";
		$events= AdminNewsEventModel::model()->findAll($c);

    	$i=1;
		foreach ($events as $event){
			if(!isset($data[$event->id])){
				$order = $maxArray + $i;
			}else{
				$order = $data[$event->id];
			}
			$eventObj = AdminNewsEventModel::model()->findByPk($event->id);
		 	$eventObj->sorder = $order;
            $eventObj->save();
            $i++;
		} */
        
        foreach($data as $k=>$v){
        	$itemObj = AdminNewsEventModel::model()->findByPk($k);
        	if(empty($itemObj)) continue;
        	$itemObj->sorder = $v;
        	$itemObj->save(false);
        }
    }


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=AdminNewsEventModel::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-news-event-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	function createImage($model,$image_path)
	{
		if(file_exists($image_path)){
			try {
				$fileSystem = new Filesystem();
				$s0Path = $model->getAvatarPath($model->id, "s0", false);// Origin
				$s1Path = $model->getAvatarPath($model->id, "s1", false);// Resize
				$s2Path = $model->getAvatarPath($model->id, "s2", false);// Thumb
				$fileSystem->mkdirs(dirname($s0Path));
				$fileSystem->mkdirs(dirname($s1Path));
				$fileSystem->mkdirs(dirname($s2Path));

				list($width, $height) = getimagesize($image_path);
				$imgCrop = new ImageCrop($image_path, 0, 0, $width, $height);

				$fileSystem->copy($image_path, $s0Path);
				$imgCrop->resizeFix($s1Path, 690, 250, 100);
				$imgCrop->resizeFix($s2Path, 100, 100, 100);
				$fileSystem->remove($image_path);
			}catch (Exception $e)
			{
				echo $e->getMessage();
			}
		}
	}
	
	public function actionMakeImg()
	{
		$id = 4;
		$model=$this->loadModel($id);
		$image_path = "/music_static/v1/tmp/20150721172125_12.jpg";
		echo $image_path."<br/>";
		
		
		$fileSystem = new Filesystem();
		$s0Path = $model->getAvatarPath($model->id,"s0",false);// Origin
		$s1Path = $model->getAvatarPath($model->id,"s1",false);// Resize
		$s2Path = $model->getAvatarPath($model->id,"s2",false);// Thumb
		$fileSystem->mkdirs(dirname($s0Path));
		$fileSystem->mkdirs(dirname($s1Path));
		$fileSystem->mkdirs(dirname($s2Path));

		list($width, $height) = getimagesize($image_path);
		$imgCrop = new ImageCrop($image_path, 0, 0, $width, $height);

		$fileSystem->copy($image_path, $s0Path);
		$imgCrop->resizeFix($s1Path, 690, 250, 100);
		$imgCrop->resizeFix($s2Path, 100, 100, 100);
			
		Yii::app()->end();
	}
}

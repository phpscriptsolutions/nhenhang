<?php

class GameEventQuestionController extends Controller
{
	
    public function init()
	{
            parent::init();
            $this->pageTitle = Yii::t('admin', "Quản lý Game Event Question ") ;
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
        $pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize',$pageSize);

		$model=new GameEventQuestionModel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['GameEventQuestionModel']))
			$model->attributes=$_GET['GameEventQuestionModel'];

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
		$model=new GameEventQuestionModel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['GameEventQuestionModel']))
		{
			$model->attributes=$_POST['GameEventQuestionModel'];
			if($model->save())
				//Create answers
				$answers_name = $_POST['answer'];
				$answers_isTrue = $_POST['answer_chk'];
				$position = array(0=>'A', 1 => 'B', 2 => 'C', 3 => 'D');
				if ($model->type == 'text') {
					for ($i = 0; $i < 4; $i++) {
						if ($answers_name[$i]) {
							$answer = new GameEventAnswerModel();
							$answer->ask_id = $model->id;
							$answer->name = $answers_name[$i];
							$answer->is_true = ($answers_isTrue == $i) ? 1 : 0;
							$answer->position = $position[$i];
							$answer->save();
						}
					}
				} else {
					$ask_image = array();
					$ask_image[] = $_POST['ask_image_0'];
					$ask_image[] = $_POST['ask_image_1'];
					$ask_image[] = $_POST['ask_image_2'];
					$ask_image[] = $_POST['ask_image_3'];
					for ($i = 0; $i < 4; $i++) {
						if ($ask_image[$i]) {
							$answer = new GameEventAnswerModel();
							$answer->ask_id = $model->id;
							$answer->name = $ask_image[$i];
							$answer->is_true = ($answers_isTrue == $i) ? 1 : 0;
							$answer->position = $position[$i];
							$answer->save();
						}
					}					
				}
				$this->redirect(array('view','id'=>$model->id));
		}

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
		
		$answers = GameEventAnswerModel::model()->findAllByAttributes(array('ask_id' => $model->id), array('order'=>'position DESC, id'));
		
		if(isset($_POST['GameEventQuestionModel']))
		{
			$model->attributes=$_POST['GameEventQuestionModel'];
			if($model->save()) {
				//Update answers
				$answers_name = $_POST['answer'];
				$answers_isTrue = $_POST['answer_chk'];
				$position = array(0=>'A', 1 => 'B', 2 => 'C', 3 => 'D');
				if ($model->type == 'text') {
					for ($i = 0; $i < 4; $i++) {
						if ($answers_name[$i]) {
							$answer = $answers[$i];
							$answer->ask_id = $model->id;
							$answer->name = $answers_name[$i];
							$answer->is_true = ($answers_isTrue == $i) ? 1 : 0;
							$answer->position = $position[$i];
							$answer->save();
						}
					}
				} else {
					$ask_image = array();
					$ask_image[] = $_POST['ask_image_0'];
					$ask_image[] = $_POST['ask_image_1'];
					$ask_image[] = $_POST['ask_image_2'];
					$ask_image[] = $_POST['ask_image_3'];
					for ($i = 0; $i < 4; $i++) {
						if ($ask_image[$i]) {
							$answer = $answers[$i];
							$answer->ask_id = $model->id;
							$answer->name = $ask_image[$i];
							$answer->is_true = ($answers_isTrue == $i) ? 1 : 0;
							$answer->position = $position[$i];
							$answer->save();
						}
					}
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}
		
				
		
		$this->render('update',array(
			'model'=>$model,
			'answers'=>$answers,
		));
	}

                /**
	 * Copy record
	 * If copy is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be copy
	 */
	public function actionCopy($id)
	{
		$data = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['GameEventQuestionModel']))
		{
                        $model=new GameEventQuestionModel;
			$model->attributes=$_POST['GameEventQuestionModel'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('copy',array(
			'model'=>$data,
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
	
	/**
    * bulk Action.
    * @param string the action
    */
    public function actionBulk() {
    	$act = Yii::app()->request->getParam('bulk_action', null);
        if (isset($act) &&  $act != "") {
        	$this->forward($this->getId()."/" . $act);
        }else {
        	$this->redirect(array('index'));
        }
	}

    /**
    * Delete all record Action.
    * @param string the action
    */
    public function actionDeleteAll() {           
    	if(isset($_POST['all-item'])){
        	GameEventQuestionModel::model()->deleteAll();
        }else{
        	$item = $_POST['cid'];
            $c =  new CDbCriteria;
            $c->condition = ('id in ('.implode($item, ",").')');
            $c->params = null;
			GameEventQuestionModel::model()->deleteAll($c);
		}
        $this->redirect(array('index'));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=GameEventQuestionModel::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='game-event-question-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionAddQuestion()
	{
		$flag=true;
		$threadId = Yii::app()->request->getParam('thread_id',"");
		if(Yii::app()->getRequest()->ispostRequest){
			$flag = false;
			$questionList = $_POST['cid'];
			
			$model = GameEventThreadModel::model()->findByPk($threadId);
			$oldQuestionList = explode(',', $model['question_list']);
						
			$newQuestionList = ($model['question_list']) ? ',' . $model['question_list'] : '';
			 
			foreach ($questionList as $question) {
				$newQuestionList .= (in_array($question, $oldQuestionList)) ? '' : ',' . $question;
			}
			$newQuestionList = ($newQuestionList != '') ? substr($newQuestionList, 1) : '';
			
			$model->question_list = $newQuestionList;
			$model->save();
			
			//AdminCollectionItemModel::model()->addList($this->userId, $collect_id, $albumList, 'album');
		}
		if($flag){
			Yii::app()->user->setState('pageSize',20);
			$questionModel = new GameEventQuestionModel();
			$questionModel->unsetAttributes();
			if(isset($_GET['GameEventQuestionModel']))
				$questionModel->attributes=$_GET['GameEventQuestionModel'];
			$questionModel->setAttributes(array('status'=>GameEventQuestionModel::PUBLISHED));
	
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			
			$this->renderPartial('addQuestion',array(
					'questionModel'=>$questionModel,
					'thread_id' => $threadId,					
			),false,true);
		}		
	}
}

<?php

class MetaDataController extends Controller
{
	public $metaTable;
	public function init()
	{
		if(empty($this->metaTable)){
			$this->metaTable = array(
				'song'=>array(
					'field_id'=>'song_id',
					'model'=>'SongModel',
					'model_meta'=>'SongMetadataModel'
				),
				'video'=>array(
					'field_id'=>'video_id',
					'model'=>'VideoModel',
					'model_meta'=>'VideoMetadataModel'
				),
				'genre'=>array(
					'field_id'=>'genre_id',
					'model'=>'GenreModel',
					'model_meta'=>'GenreMetadataModel'
				),
				'album'=>array(
					'field_id'=>'album_id',
					'model'=>'AlbumModel',
					'model_meta'=>'AlbumMetadataModel'
				),
				'artist'=>array(
					'field_id'=>'artist_id',
					'model'=>'ArtistModel',
					'model_meta'=>'ArtistMetadataModel'
				),
				'collection'=>array(
					'field_id'=>'collection_id',
					'model'=>'CollectionModel',
					'model_meta'=>'CollectionMetadataModel'
				),
			);
		}
		parent::init();
	}
	public function actionAdmin()
	{
		$metaData = NULL;
		$content = NULL;
		$contentId = NULL;
		$contentType = NULL;
		if(Yii::app()->request->isAjaxRequest){
			$result = new stdClass();
			$result->msg = "Can not update meta data!";
			$data = Yii::app()->request->getParam('data');
			$params = array();
			$d = parse_str($data, $params);
			$contentId = $params['MetaData']['content_id'];
			$contentType = $params['MetaData']['content_type'];
			if(!empty($contentId) && !empty($contentType)) {
				$idFieldName = $this->metaTable[$contentType]['field_id'];
				$modelName = $this->metaTable[$contentType]['model'];
				$modelMetaName = $this->metaTable[$contentType]['model_meta'];
				$content = $modelName::model()->findByPk($contentId);
				if ($content) {
					if($this->updateData($contentId,$modelMetaName,$idFieldName,$params['MetaData'])){
						$result->errorCode=0;
						$result->msg = "Update meta data success!";
					}else{
						$result->msg = "Update meta data error!";
					}
				} else {
					$result->msg = "Find not found content!";
				}
			}
			echo CJSON::encode($result);
			Yii::app()->end();
		}
		$this->render('admin', compact('metaData','content','contentId','contentType'));
	}
	public function actionFindContentMeta()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$data = Yii::app()->request->getParam('data');
			$params = array();
			$d = parse_str($data, $params);
			$contentId = $params['Find']['content_id'];
			if(!is_numeric($contentId)){
				Yii::import("application.vendors.Hashids.*");
				$hashids = new Hashids(Yii::app()->params["hash_url"]);
				$hashStrId = substr($contentId, 2);
				$parse = $hashids->decode($hashStrId);
				$contentId = $parse[0];
			}
			$contentType = $params['Find']['content_type'];
			if(!empty($contentId) && !empty($contentType)) {
				$idFieldName = $this->metaTable[$contentType]['field_id'];
				$modelName = $this->metaTable[$contentType]['model'];
				$modelMetaName = $this->metaTable[$contentType]['model_meta'];
				$content = $modelName::model()->findByPk($contentId);
				//var_dump($content);exit;
				if ($content) {
					$crit = new CDbCriteria();
					$crit->condition = "$idFieldName=:id";
					$crit->params = array(':id' => $contentId);
					$contentMetaData = $modelMetaName::model()->findAll($crit);
					$metaData = $this->convertArray($contentMetaData);
				} else {
					echo 'Find not found this content';
					Yii::app()->end();
				}
			}else{
				echo 'params not valid';
				Yii::app()->end();
			}
			$this->renderPartial('find_content_meta', compact('metaData','content','contentId','contentType'));
		}
	}
	public function actionDeleteMeta()
	{
		if(Yii::app()->request->isAjaxRequest){
			$result = new stdClass();
			$result->msg = "Can not delete meta data!";
			$data = Yii::app()->request->getParam('data');
			$params = array();
			$d = parse_str($data, $params);
			$contentId = $params['MetaData']['content_id'];
			$contentType = $params['MetaData']['content_type'];
			if(!empty($contentId) && !empty($contentType)) {
				$idFieldName = $this->metaTable[$contentType]['field_id'];
				$modelName = $this->metaTable[$contentType]['model'];
				$modelMetaName = $this->metaTable[$contentType]['model_meta'];
				$content = $modelName::model()->findByPk($contentId);
				if ($content) {
					if($this->updateData($contentId,$modelMetaName,$idFieldName,$params['MetaData'], true)){
						$result->errorCode=0;
						$result->msg = "Delete meta data success!";
					}else{
						$result->msg = "Delete meta data error!";
					}
				} else {
					$result->msg = "Find not found content!";
				}
			}
			echo CJSON::encode($result);
			Yii::app()->end();
		}
	}
	private function updateData($id,$model,$idFieldName,$data,$isDelete=false)
	{
		if(!empty($id)){
			$crit = new CDbCriteria();
			$crit->condition = "$idFieldName=:id";
			$crit->params = array(':id'=>$id);
			$delete = $model::model()->deleteAll($crit);
			if(!$isDelete) {
				foreach ($data as $key => $value) {
					if (in_array($key, array('title', 'keywords', 'description'))) {
						$meta = new $model;
						$meta->$idFieldName = $id;
						$meta->meta_key = $key;
						$meta->meta_value = $value;
						$meta->save(false);
					}
				}
			}
		}
		return true;
	}
	private function convertArray($contentMetaData)
	{
		$metaData = array();
		if(!empty($contentMetaData)){
			foreach($contentMetaData as $meta){
				if(!empty($meta))
					$metaData[$meta->meta_key] = $meta->meta_value;
			}
		}
		return $metaData;
	}
}
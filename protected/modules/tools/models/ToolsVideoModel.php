<?php

Yii::import('application.models.admin.AdminVideoModel');
class ToolsVideoModel extends AdminSongModel
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function getVideoToHide()
	{
		$sql = "SELECT distinct video_id, id, reason
				FROM video_to_hide
				where status=0
				LIMIT 1
				";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}
	public function updateStatus($id)
	{
		$sql = "UPDATE video_to_hide SET status=1 WHERE id=$id";
		return Yii::app()->db->createCommand($sql)->execute();
	}
}
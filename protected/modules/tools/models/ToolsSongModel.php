<?php

Yii::import('application.models.admin.AdminSongModel');
class ToolsSongModel extends AdminSongModel
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function getSongToHide()
	{
		$sql = "SELECT distinct song_id, id, reason
				FROM song_to_hide
				where status=0
				LIMIT 1
				";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}
	public function getSongToRestore()
	{
		$sql = "SELECT distinct song_id, id, reason
				FROM song_to_restore
				where status=0
				LIMIT 1
				";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}
	public function updateStatusRestore($id, $status=1)
	{
		$sql = "UPDATE song_to_restore SET status=$status WHERE id=$id";
		return Yii::app()->db->createCommand($sql)->execute();
	}
	public function updateStatus($id, $status=1)
	{
		$sql = "UPDATE song_to_hide SET status=$status WHERE id=$id";
		return Yii::app()->db->createCommand($sql)->execute();
	}
}
<?php

class CopyrightInputContentModel extends BaseCopyrightInputContentModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CopyrightInputContent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getListSong($fileId,$limit = 30,$offset = 0)
	{
		$sql = "SELECT t1.*, t2.content_type
				FROM copyright_input_content t1
				LEFT JOIN copyright_input_file t2 ON t2.id = t1.input_file
				WHERE t1.input_file=:FID
				ORDER BY t1.id ASC, t2.id ASC, t2.content_type ASC
				LIMIT :LIMIT
				OFFSET :OFFSET
				";
		$dataCmd = Yii::app()->db->createCommand($sql);
		$dataCmd->bindParam(":FID", $fileId, PDO::PARAM_INT);
		$dataCmd->bindParam(":LIMIT", $limit, PDO::PARAM_INT);
		$dataCmd->bindParam(":OFFSET", $offset, PDO::PARAM_INT);
		return $dataCmd->queryAll();
	}

	public function getCountSong($fileId)
	{
		$sql = "SELECT count(*) AS total
				FROM copyright_input_content t1
				LEFT JOIN copyright_content_map t2 ON t1.id = t2.input_id
				WHERE t1.input_file=:FID
				";
		$dataCmd = Yii::app()->db->createCommand($sql);
		$dataCmd->bindParam(":FID", $fileId, PDO::PARAM_INT);
		$data =  $dataCmd->queryRow();
		return empty($data)?0:$data["total"];
	}
        public function getListContentNotMapped($fileId, $content_type)
	{
		$sql = "SELECT * FROM copyright_input_content
                        WHERE input_file =:FID 
                            AND id NOT IN (SELECT input_id 
                                            FROM copyright_content_map 
                                            WHERE content_type =:contentType)";
		$dataCmd = Yii::app()->db->createCommand($sql);
		$dataCmd->bindParam(":FID", $fileId, PDO::PARAM_INT);
		$dataCmd->bindParam(":contentType", $content_type, PDO::PARAM_STR);
		return $dataCmd->queryAll();
	}
}
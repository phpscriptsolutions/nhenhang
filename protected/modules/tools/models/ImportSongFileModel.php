<?php
class ImportSongFileModel extends BaseImportSongFileModel
{
    var $className = __CLASS__;
	protected $_order = "";
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    public function relations()
    {
    	return array(
    			'totalSong'=>array(self::STAT, 'ImportSongModel','file_id'),
    			);
    }
    public function search()
    {
    	// Warning: Please modify the following code to remove attributes that
    	// should not be searched.
    
    	$criteria=new CDbCriteria;
    
    	$criteria->compare('id',$this->id);
    	$criteria->compare('file_name',$this->file_name,true);
    	$criteria->compare('importer',$this->importer,true);
    	$criteria->compare('status',$this->status);
    	$criteria->compare('created_time',$this->created_time,true);
    	$criteria->condition = "type='CHECK'";
    	if(!empty($this->_order)){
    		$criteria->order = "{$this->_order}";
    	}
    	return new CActiveDataProvider($this, array(
    			'criteria'=>$criteria,
    			'pagination'=>array(
    					'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
    			),
    	));
    }
    public static function updateStatImport($fileId)
    {
    	$sql = "SELECT count(*) as cnt, error_code 
    			FROM import_song
    			WHERE file_id=:fid and status>0
    			GROUP BY error_code
    			";
    	$command = Yii::app()->db->createCommand($sql);
    	$command->bindParam(':fid', $fileId, PDO::PARAM_INT);
    	$result = $command->queryAll();
    	$sql = "SELECT count(id) as cnt FROM import_song WHERE file_id=:fid and status=0";
    	$command = Yii::app()->db->createCommand($sql);
    	$command->bindParam(':fid', $fileId, PDO::PARAM_INT);
    	$total = $command->queryScalar();
    	$params = "<div>($total) (Chưa chạy Import) (<a href='".$link = Yii::app()->createUrl('import_song/importSong/index', array('status'=>0, 'fileId'=>$fileId))."'>Filter</a>)</div>";
    	foreach($result as $res){
    		switch ($res['error_code']){
    			case 2:
    				$errorDesc = "Không save được vào song";
    				break;
    			case 3:
    				$errorDesc = 'Hết quyền upload bài hát';
    				break;
    			case 4:
    				$errorDesc = 'File mp3 trống';
    				break;
    			case -1:
    				$errorDesc = "File không tồn tại";
	    			break;
    			default:
    				$errorDesc = "Import thành công";
    				break;
    		}
    		$link = Yii::app()->createUrl('import_song/importSong/index', array('errorCode'=>$res['error_code'], 'fileId'=>$fileId));
    		$params .= "<div>({$res['cnt']}) ($errorDesc) (<a href='$link'>Filter</a>)</div>";
    	}
    	$sql = "SELECT estimate_time FROM import_song WHERE file_id=$fileId and status=1 and estimate_time>0 ORDER BY id DESC LIMIT 1";
    	$estimate = Yii::app()->db->createCommand($sql)->queryScalar();
    	$es = self::convertTime($total*$estimate);
    	$params .="<div>Trend time: ".$es." </div>";
    	$sql = "UPDATE import_song_file set params=:params WHERE id=$fileId";
    	$command = Yii::app()->db->createCommand($sql);
    	$command->bindParam(':params', $params, PDO::PARAM_STR);
    	return $command->execute();
    }
    public static function convertTime($totalSeconds)
    {
    	$init = $totalSeconds;
    	$hours = floor($init / 3600);
    	$minutes = floor(($init / 60) % 60);
    	$seconds = $init % 60;
    	
    	return "{$hours}giờ {$minutes}phút {$seconds}giây";
    }
}
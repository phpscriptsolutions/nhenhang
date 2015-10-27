<?php

Yii::import('application.models.db.AdminUserModel');

class AdminAdminUserModel extends AdminUserModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function relations()
    {
        return  CMap::mergeArray( parent::relations(),   array(
            'cp'=>array(self::BELONGS_TO, 'AdminCpModel', 'cp_id', 'select'=>'id, name'),
        ));
    }


    public function getMaxContentCode($cpId,$content = 'song')
    {
    	$cpObj = AdminCpModel::model()->findByPk($cpId);
    	$limitCode = $cpObj['code'] + Yii::app()->params['cp_limit_content'];

        switch ($content){
        	case "video":
        		$c = new CDbCriteria();
            	$c->select = "code";
            	$c->condition = "cp_id=:CPID";
            	$c->params = array(':CPID'=>$cpId);
            	$c->order = "code DESC";
            	$c->limit = 1;
            	$video = AdminVideoModel::model()->find($c);
            	$maxCode = isset($video['code'])?$video['code']:0 ;
            	//echo $maxCode; exit;
            	if($maxCode >= $limitCode) return false;
            	else if(($maxCode < $cpObj['code']) || ($maxCode <=0)) {
					return $cpObj['code'];
				}
                else return $maxCode+1;
        		break;
        	case "ringtone":


        		$c = new CDbCriteria();
            	$c->select = "code";
            	$c->condition = "cp_id=:CPID";
            	$c->params = array(':CPID'=>$cpId);
            	$c->order = "code DESC";
            	$c->limit = 1;

            	$ringtone = AdminRingtoneModel::model()->find($c);
            	$maxCode = isset($ringtone['code'])?$ringtone['code']:0 ;
            	if($maxCode >= $limitCode) return false;
            	else if(($maxCode < $cpObj['code']) || ($maxCode <=0)) {
					return $cpObj['code'];
				}
                else return $maxCode+1;
        		break;
        	case "song":
            default:
            	$c = new CDbCriteria();
            	$c->select = "code";
            	$c->condition = "cp_id=:CPID";
            	$c->params = array(':CPID'=>$cpId);
            	$c->order = "code DESC";
            	$c->limit = 1;
            	$song = AdminSongModel::model()->find($c);

            	$maxCode = isset($song['code'])?$song['code']:0 ;
            	if($maxCode >= $limitCode) return false;
            	else if(($maxCode < $cpObj['code']) || ($maxCode <=0)) {
					$code = $cpObj['code'];
				}
                else $code = $maxCode+1;
                
                //check exist code
                if($code>=$maxCode){
	                $e = 0;
	                while($e==0){
	                	$sql = "SELECT count(*) FROM song WHERE code='$code'";
	                	$count = Yii::app()->db->createCommand($sql)->queryScalar();
	                	if($count>0){
	                		$code++;
	                	}else{
	                		$e++;
	                	}
	                }
                }
                
                return $code;
            	break;
        }
    }
}
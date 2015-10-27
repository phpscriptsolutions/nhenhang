<?php

/**
 * Lop active record danh cho cac noi dung: song, video, album, playlist, ringtone, rbt
 */
class MainContentModel extends MainActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Album the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }


    /**
     * Lay ten coloumn dung de suggest
     * @param INT $suggestedId
     * @return STRING
     */
    public static function getSuggestedColNameById($suggestedId) {
        return "suggest_$suggestedId";
    }
    /**
     * Count danh sach noi dung theo collection
     * @param INT $page
     * @param INT $limit
     * @return \CActiveDataProvider
     */
    public static function countListByCollection($collectionCode, $filter_sync_status = '') {
    	$collection = Yii::app()->cache->get("COLLECTION_$collectionCode");
    	if(false===$collection){
    		$collection = CollectionModel::model()->findByAttributes(array('code' => $collectionCode));
    		Yii::app()->cache->set("COLLECTION_$collectionCode",$collection,Yii::app()->params['cacheTime']);
    	}

        if(!empty($collection))
            return $collection->getItems(0,1,$filter_sync_status,true);
        return null;

    }
    /**
     * Lay danh sach noi dung theo collection
     * @param INT $page
     * @param INT $limit
     * @param boolean $filter_sync_status: neu = true => chi lay item ma sync_status = 1
     * @param boolean $filterByDomain: neu = true => loc Collection tuong ung cua moi domain
     * @return \CActiveDataProvider
     */
    public static function getListByCollection($collectionCode, $page = 1, $limit = 0, $filter_sync_status = '') {
        $cache_code = "COLLECTION_{$collectionCode}_page_{$page}_limit_{$limit}";
        $collection = Yii::app()->cache->get($cache_code);
        if(false === $collection){
        	$collection = CollectionModel::model()->findByAttributes(array('code' => $collectionCode));
        	Yii::app()->cache->set($cache_code,$collection,Yii::app()->params['cacheTime']);
        }


        if($collection)
            return  $collection->getItems($page, $limit, $filter_sync_status);
        return null;
    }
    
    public static function getListByCollectionByDistrict($collectionCode, $district, $page = 1, $limit = 0) {
       	$cache_code = "COLLECTION_{$collectionCode}_page_{$page}_limit_{$limit}_district_{$district}";
    	$collection = Yii::app()->cache->get($cache_code);
    	if(false === $collection){
    		$collection = CollectionModel::model()->findByAttributes(array('code' => $collectionCode));
    		Yii::app()->cache->set($cache_code,$collection,Yii::app()->params['cacheTime']);
    	}
    
    	if($collection)
    		return  $collection->getItemsByDistrict($page, $limit, $district);
    	return array();
    }



    public static function getUserInfo($phone = null){
        if(!isset($phone))
            $phone = yii::app()->user->getState('msisdn');
        $cri = new CDbCriteria;
        $cri->condition = " phone = '$phone'";
        $user = UserModel::model()->find($cri);
        return $user;
    }

    public static function getListByCollectionForClient($collectionCode,$limit = 10, $offset = 0) {
        $cache_code = "COLLECTION_{$collectionCode}_page_{$offset}_limit_{$limit}";
        $collection = Yii::app()->cache->get($cache_code);
        if(false === $collection){
        	$collection = CollectionModel::model()->findByAttributes(array('code' => $collectionCode));
        	Yii::app()->cache->set($cache_code,$collection,Yii::app()->params['cacheTime']);
        }
        if($collection)
              if($collection->mode == CollectionModel::MODE_AUTO) return $collection->_getItemsAutoClient($offset, $limit);
        else return $collection->_getItemsManualClient($offset, $limit);
//            return  $collection->_getItemsManualClient($offset, $limit);
        return null;

    }
    
    /**
     * Count danh sach noi dung theo collection
     * @param INT $page
     * @param INT $limit
     * @return \CActiveDataProvider
     */
    public static function countListByCollectionForClient($collectionCode) {
    	$collection = Yii::app()->cache->get("COLLECTION_$collectionCode");
    	if(false===$collection){
    		$collection = CollectionModel::model()->findByAttributes(array('code' => $collectionCode));
    		Yii::app()->cache->set("COLLECTION_$collectionCode",$collection,Yii::app()->params['cacheTime']);
    	}
//        if(!empty($collection))
//            return $collection->_getItemsManualClient(0,1,true);
         if($collection)
              if($collection->mode == CollectionModel::MODE_AUTO) return $collection->_getItemsAutoClient(0, 1, true);
        else return $collection->_getItemsManualClient(0,1,true);
        return null;

    }

	public function __get($name)
	{
		if($name == 'url_key'){
			$str = trim(parent::__get($name),"-");
			$str = str_replace("--", "-", $str);
			if(strrpos($str, "-")===false){
				$str = Common::makeFriendlyUrl(trim($str));
			}
			return  str_replace("'", "", $str); ;
		}
		return parent::__get($name);
	}

}

?>
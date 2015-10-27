<?php

class MainActiveRecord extends CActiveRecord {

    public $useMasterDb = false;

    public function onBeforeSave($event) {
        $this->useMasterDb = true;
        parent::onBeforeSave($event);
    }

    public function onAfterSave($event) {
        $this->useMasterDb = false;
        parent::onAfterSave($event);
    }

    public function onBeforeDelete($event) {
        $this->useMasterDb = true;
        parent::onBeforeDelete($event);
    }

    public function onAfterDelete($event) {
        $this->useMasterDb = false;
        parent::onAfterDelete($event);
    }

    public function getDbConnection() {
        if (!$this->useMasterDb) {
            if (isset(Yii::app()->dbslave)) {
                return Yii::app()->dbslave;
            }
        } else {
            return Yii::app()->db;
        }
        return Yii::app()->db;
    }

    /**
     * get Metadata duoc thiet lap boi Admin
     */
    function getCustomMetaData($meta_key, $index = 2) {       
        $cusData = Yii::app()->db->createCommand()
                ->select('comment,value')
                ->from('config')
                ->where('name=:name', array(':name' => $meta_key))
                ->queryRow();
        ///var_dump($cusData);
        $customData = ($index == 1) ? $cusData['comment'] : $cusData['value'];
        return $customData;
    }
    
    /**
     * lay Genre cha, Genre hot 
     * @return type 
     */
    public static function getGenre($hot = 1){
        if($hot == 1){
            $cri = new CDbCriteria;
            $cri->condition = "status = 1";
            $cri->order = "sorder ASC";
            $cri->limit = 10;
            $genres = GenreModel::model()->findAll($cri);
        }
        else{
            $cri = new CDbCriteria;
            $cri->condition = "parent_id = 0 AND status = 1";
            $cri->order = "sorder ASC";
            $genres = GenreModel::model()->findAll($cri);
        }
        return $genres;
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
}

?>
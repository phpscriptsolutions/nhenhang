<?php
/**
 * Created by PhpStorm.
 * User: tiennt
 * Date: 06/08/2015
 * Time: 10:51
 */

class MongoModel{
    public $db;

    public function __construct()
    {
        if (empty($this->db)) {
            $this->db = Yii::app()->mongodb->getDB();
            if (empty($this->db)) {
                throw new CustomMongoException('Cannot connection mongo db.');
            }
        }
    }

    public function insert($collection = null, $data = null){
        if(empty($collection) || (empty($data) || (!is_array($data) && !is_object($data)))){
            return false;
        }

        $rs = $this->db->$collection->save($data);

        if(!empty($rs['err'])){
            return false;
        }

        return $data['_id'];
    }

    public function getAll($collection = null, $query = null, $select = null, $sort = null, $limit = 0, $skip = 0){
        if(empty($collection) || (empty($query))){
            return false;
        }
        $data = null;
        if(!empty($select)){
            $data = $this->db->$collection->find($query,$select);
        }else{
            $data = $this->db->$collection->find($query);
        }

        if(!empty($sort)){
            $data = $data->sort($sort);
        }

        if($limit){
            $data = $data->limit($limit)->skip($skip);
        }

        return $data;
    }

    /**
     * find one document from collection
     * @param null $collection
     * @param null $query
     * @param null $fields : array select fields
     * @return null
     */
    public function getOne($collection = null, $query = null, $fields = null){
        if(empty($collection) || empty($query) || (!is_array($query) && !is_object($query))){
            return null;
        }

        if(empty($fields)){
            return $this->db->$collection->findOne($query);
        }else{
            return $this->db->$collection->findOne($query,$fields);
        }
    }

    /**
     * @return mixed
     */
    public function getCron(){
        $data = $this->db->cron
            ->find()
            ->sort(array('to_time'=>-1))
            ->limit(1)->getNext();

        return $data;
    }

    public function aggregate($collection = null, $pipe = null){
        if(empty($collection) || empty($pipe)){
            return null;
        }
        return $this->db->$collection->aggregate($pipe);
    }

    public function update($collection = null, $data = null, $query = null){
        if(empty($collection) || empty($data) || empty($query)){
            return false;
        }

        $rs = $this->db->$collection->update($query,$data);
        if(empty($rs) || !empty($rs['err'])){
            return false;
        }
        return true;
    }
}

class CustomMongoException extends Exception{

}
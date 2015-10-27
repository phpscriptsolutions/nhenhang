<?php
Yii::import('application.models.mongo.*');
class WapMongoModel extends MongoModel{

    /**
     * @param $userId
     * @param $now
     * @param $type
     * @return int
     */
    public function countTotalPlay($userId, $now, $type){
        if(empty($userId) || empty($now) || empty($type)){
            return 0;
        }

        $fromTime = $now - 7*86400;
        $query = array(
            'user_id' => (int)$userId,
            'loged_time' => array(
                '$gte' => new MongoDate($fromTime)
            )
        );

        $collection = array(
            'song' => 'song_play',
            'album' => 'album_play',
            'video' => 'video_play'
        );

        $pipe = array(
            array(
                '$match' => $query
            ),
            array(
                '$group' => array(
                    '_id' => '$'.$type.'_id'
                )
            ),
            array(
                '$group' => array(
                    '_id' => null,
                    'total' => array(
                        '$sum'=>1
                    )
                )
            )
        );

        try {
            $total = 0;
            $logs = $this->aggregate($collection[$type], $pipe);

            if (!empty($logs) && count($logs['result'])) {
                foreach ($logs['result'] as $row) {
                    $total = $row['total'];
                }
            }
            return $total;

        }catch (Exception $ex){
            return 0;
        }
    }

    /**
     * @param $userId
     * @param $type
     * @param $now
     * @param int $limit
     * @param int $offset
     * @return null
     */
    public function getPlay($userId,$type,$now, $limit=5,$offset=0){
        if(empty($userId) || empty($type)){
            return null;
        }
        $tables = array(
            'mysql' => array(
                'song' => 'WapSongModel',
                'album' => 'AlbumModel',
                'video' => 'WapVideoModel'
            ),
            'mongo'=> array(
                'song' => 'song_play',
                'album' => 'album_play',
                'video' => 'video_play'
            )
        );
        $now = (empty($now))?time():$now;

        $fromTime = $now - 7*86400;
        $query = array(
            'user_id' => (int)$userId,
            'loged_time' => array(
                '$gte' => new MongoDate($fromTime)
            )
        );

        $pipe = array(
            array(
                '$match' => $query
            ),
            array(
                '$group' => array(
                    '_id' => '$'.$type.'_id',
                    'name' => array(
                        '$first'=>'$song_name'
                    ),
                    'loged_time' => array(
                        '$max' => '$loged_time'
                    )
                )
            ),
            array(
                '$sort' => array(
                    'loged_time' => -1
                )
            ),
            array(
                '$skip'=> $offset
            ),
            array(
                '$limit' => $limit
            )
        );

        //lay ra limit ban ghi tu mongo
        $logs = $this->aggregate($tables['mongo'][$type],$pipe);

        if(empty($logs) || count($logs['result'])==0){
            $data = null;
        }else{
            $ids = array();
            foreach($logs['result'] as $row){
                $ids[] = $row['_id'];
            }
            //lay data tu mysql
            $crit = new CDbCriteria();
            $crit->addInCondition('id',$ids);
            if(count($ids)>1) {
                $crit->order = 'FIELD(id,' . implode(',', $ids) . ')';
            }
            $data = $tables['mysql'][$type]::model()->findAll($crit);
        }
        return $data;
    }
}
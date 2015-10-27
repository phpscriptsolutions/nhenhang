<?php
Yii::import('application.models.mongo.*');
class WebMongoModel extends MongoModel
{
    public $_recent_time=0;
    public function __construct($time='')
    {
        parent::__construct();
        $this->_recent_time = empty($time)?time()-7*86400:time()-$time;
    }
    public function getTotalRecently($userId,$type='song')
    {
        $fromTime = $this->_recent_time;//90 ngay gan day
        $tables = array(
            'mysql' => array(
                'song' => 'WebSongModel',
                'album' => 'WebAlbumModel',
                'video' => 'WebVideoModel'
            ),
            'mongo'=> array(
                'song' => 'song_play',
                'album' => 'album_play',
                'video' => 'video_play'
            )
        );
        $result = null;
        try {
            $mongoModel = new MongoModel();
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
            //lay ra limit ban ghi tu mongo
            $data = $mongoModel->aggregate($tables['mongo'][$type], $pipe);
            $total = 0;
            if($data && count($data['result'])>0){
                foreach ($data['result'] as $row) {
                    $total = $row['total'];
                }
            }
            return $total;
        }catch (Exception $e)
        {
            //echo $e->getMessage();
            return 0;
        }
        return 0;
    }
    public function getRecently($userId,$type='song',$limit=10,$offset=0)
    {
        $fromTime = $this->_recent_time;//90 ngay gan day
        $tables = array(
            'mysql' => array(
                'song' => 'WebSongModel',
                'album' => 'AlbumModel',
                'video' => 'WebVideoModel'
            ),
            'mongo'=> array(
                'song' => 'song_play',
                'album' => 'album_play',
                'video' => 'video_play'
            )
        );
        $result = null;
        try {
            $mongoModel = new MongoModel();
            $query = array(
                'user_id' => (int)$userId,
                'loged_time' => array(
                    '$gte' => new MongoDate($fromTime)
                )
            );
            $pos_from = $offset;
            $pos_to = $pos_from + $limit;
            $pipe = array(
                array(
                    '$match' => $query
                ),
                array(
                    '$group' => array(
                        '_id' => '$' . $type . '_id',
                        'name' => array(
                            '$first' => '$song_name'
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
                    '$skip' => (int) $pos_from,
                ),
                array(
                    '$limit' => (int) $limit,
                )

            );
            //lay ra limit ban ghi tu mongo
            $data = $mongoModel->aggregate($tables['mongo'][$type], $pipe);
            if($data && count($data['result'])>0){
                $ids = array();
                foreach($data['result'] as $row){
                    $ids[] = $row['_id'];
                }
                //lay data tu mysql
                $crit = new CDbCriteria();
                $crit->addInCondition('id',$ids);
                if(count($ids)>1) {
                    $crit->order = 'FIELD(id,' . implode(',', $ids) . ')';
                }
                $result = $tables['mysql'][$type]::model()->findAll($crit);
            }
        }catch (Exception $e)
        {
            //echo $e->getMessage();
            return false;
        }
        return $result;
    }
}
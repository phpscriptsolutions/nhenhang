<?php
/**
 * Created by PhpStorm.
 * User: tiennt
 * Date: 05/08/2015
 * Time: 17:15
 */
class UserActivityMongoModel extends EMongoDocument{
    public function collectionName(){
        return 'user_activity';
    }

    public static function model($className = __CLASS__){
        return parent::model($className);
    }

    /**
     * insert document vao collection
     * @param null $data
     * @return bool
     */
    public function insert($data = null){
        if(empty($data) || (!is_array($data) && !is_object($data))){
            return false;
        }

        $rs = self::getCollection()->save($data);

        if(!empty($rs['err'])){
            return false;
        }

        return $data['_id'];
    }

    public function add($params){
        //save vao user_activity collection
        $logUser = array();
        $logUser['user_id'] = isset ( $params ['user_id'] ) ? (int)$params ['user_id'] : '0';
        $logUser['user_phone'] = $params ["msisdn"];
        $logUser['user_ip'] = isset($params['user_ip'])?$params ["user_ip"]:$_SERVER['REMOTE_ADDR'];
        $logUser['user_agent'] = isset($params['user_agent'])?$params ["user_agent"]:$_SERVER['HTTP_USER_AGENT'];
        $logUser['activity'] = $params ["cmd"];
        $logUser['channel'] = $params ["source"];
        $logUser['obj_id'] = isset ( $params ['obj_id'] ) ? (int)$params ['obj_id'] : 0;
        $logUser['obj_name'] = isset ( $params ['obj_name'] ) ? $params ['obj_name'] : '';
        $logUser['note'] = isset ( $params ['note'] ) ? $params ['note'] : '';
        $logUser['from_ads'] = (isset($params['from_ads']))?$params['from_ads']:'';
        $logUser['media_url'] = (isset($params['media_url']))?$params['media_url']:'';
        $logUser['uri'] = (isset($params['uri']))?$params['uri']:'';
        $logUser['referrer'] = (isset($params['referrer']))?$params['referrer']:'';
        $logUser['loged_time'] = new MongoDate(strtotime($params ['createdDatetime']));

        $_id = self::insert($logUser);

        //insert vao song
        if($_id){
            $insert = true;

            $mongoModel = new MongoModel();
            switch ($logUser['activity']){
                case "play_song":
                    $songPlay = array();
                    $songPlay['song_id'] = $logUser['obj_id'];
                    $songPlay['song_name'] = $logUser['obj_name'];
                    $songPlay['user_id']  = $logUser['user_id'];
                    $songPlay['user_ip'] = $logUser['user_ip'];
                    $songPlay['user_phone'] = $logUser['user_phone'];
                    $songPlay['activity_id'] = $_id;
                    $songPlay['loged_time'] = $logUser['loged_time'];

                    $insert = $mongoModel->insert('song_play',$songPlay);
                    break;
                case "play_video":
                    $videoPlay = array();
                    $videoPlay['video_id'] = $logUser['obj_id'];
                    $videoPlay['video_name'] = $logUser['obj_name'];
                    $videoPlay['user_id']  = $logUser['user_id'];
                    $videoPlay['user_ip'] = $logUser['user_ip'];
                    $videoPlay['user_phone'] = $logUser['user_phone'];
                    $videoPlay['activity_id'] = $_id;
                    $videoPlay['loged_time'] =  $logUser['loged_time'];

                    $insert = $mongoModel->insert('video_play',$videoPlay);

                    break;
                case 'playlist':
                case "play_album":
                    $albumPlay = array();
                    $albumPlay['album_id'] = $logUser['obj_id'];
                    $albumPlay['album_name'] = $logUser['obj_name'];
                    $albumPlay['user_id']  = $logUser['user_id'];
                    $albumPlay['user_ip'] = $logUser['user_ip'];
                    $albumPlay['user_phone'] = $logUser['user_phone'];
                    $albumPlay['activity_id'] = $_id;
                    $albumPlay['loged_time'] = $logUser['loged_time'];

                $insert = $mongoModel->insert('album_play',$albumPlay);
                    break;

            }

            if(!$insert){
                return false;
            }

            return true;
        }else{
            return false;
        }

    }
}
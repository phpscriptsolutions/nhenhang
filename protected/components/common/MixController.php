<?php
class MixController extends CExtController {

    public function actionGetTotalView(){
        $id         = Yii::app()->request->getParam('id',0);
        $type       = Yii::app()->request->getParam('type','play_count');
        $category   = Yii::app()->request->getParam('category');

        if(!empty($id) && !empty($type) && in_array($type,array('played_count','downloaded_cound'))
            && in_array($category,array('song', 'album', 'playlist', 'video', 'video_playlist')) ) {

            switch($category){
                case 'song':
                    $info = SongStatisticModel::model()->find('song_id=:song_id',array(':song_id'=>$id));
                    $title = Yii::t('web','Lượt nghe');
                    break;
                case 'album':
                case 'playlist':
                    $info = AlbumStatisticModel::model()->find('album_id=:album_id',array(':album_id'=>$id));
                    $title = Yii::t('web','Lượt nghe');
                    break;
                case 'video':
                case 'video_playlist':
                    $info = VideoStatisticModel::model()->find('video_id=:video_id',array(':video_id'=>$id));
                    $title = Yii::t('web','Lượt xem');
                    break;
            }


            $title = ($type=='played_count')?$title:Yii::t('web','Lượt tải');

            if($info){
                echo $info->$type.' '.$title;
            }else{
                echo '0 '.$title;
            }

        }
        Yii::app()->end();
    }
    public function actionGetTotalFauvorite()
    {
        $result = array();
        $result['errorCode']=0;
        $result['data']=1;
        $result['msg']='success';
        $id         = Yii::app()->request->getParam('id',0);
        $type       = Yii::app()->request->getParam('type','fauvorite');
        $category   = Yii::app()->request->getParam('category');
        try {
            switch ($category) {
                case 'video':
                    $count = VideoModel::model()->getCountFav($id);
                    break;
                case 'song':
                    $count = SongModel::model()->getCountFav($id);
                    break;
                case 'album':
                    $count = AlbumModel::model()->getCountFav($id);
                    break;
                default:
                    $count=0;
                    break;
            }
            $result['data']=$count;
        }catch (Exception $e)
        {
            $result['msg'] = $e->getMessage();
            $result['data']=0;
        }
        echo CJSON::encode($result);
        Yii::app()->end();
    }
    public function actionIsMyPlaylist()
    {
        $contentId = (int) Yii::app()->request->getParam('id',0);
        $contentType = Yii::app()->request->getParam('type');
        $userId = Yii::app()->user->id;
        $data = new stdClass();
        $data->code=0;
        $data->msg = 'fail';
        if($contentId>0 && in_array($contentType,array('album')) && $userId>0){
            $crit = new CDbCriteria();
            $crit->condition = "user_id=:id AND album_id=:album_id";
            $crit->params = array(':id'=>$userId, ':album_id'=>$contentId);
            $result = FavouriteAlbumModel::model()->find($crit);
            if($result){
                $data->code=1;
                $data->msg = 'success';
            }
        }elseif($contentId>0 && $contentType=='video' && $userId>0){
            $crit = new CDbCriteria();
            $crit->condition = "user_id=:id AND video_id=:video_id";
            $crit->params = array(':id'=>$userId, ':video_id'=>$contentId);
            $result = FavouriteVideoModel::model()->find($crit);
            if($result){
                $data->code=1;
                $data->msg = 'success';
            }
        }
        echo CJSON::encode($data);
        Yii::app()->end();
    }
}
<?php
class ApiController extends Controller{
    public function actionChapter(){
        $storyId = Yii::app()->request->getParam('story_id');
        $limit = (int) Yii::app()->request->getParam('limit',100);
        $offset = (int)Yii::app()->request->getParam('offset',0);
        if(empty($storyId)){
            exit(json_encode(array('status'=>false,'msg'=>'Invalid param','data'=>null)));
        }

        //lay thong tin story xem full hay chua
        $story = QuotevStoryModel::model()->findByPk($storyId);

        //lay thong tin truyen
        $chapterModel = new ChapterModel();
        $chapters = $chapterModel->getChapterByStoryId('quotev_chapter',$storyId,$limit,$offset);

        $isFull = 0;

        if(!empty($story) && $story->status == 'Full'){
            if(count($chapters)<$limit){
                $isFull = 1;
            }
        }
        if(empty($chapters)){
            exit(json_encode(array('status'=>true,'msg'=>'Đã hết dữ liệu','data'=>null,'is_full'=>$isFull,"story_id"=>$storyId)));
        }

        $data = array();
        foreach($chapters as $chapter){
            $data[] = array(
                'story_name' => $chapter['story_name'],
                'story_id' => $chapter['story_id'],
                'chapter_name' => $chapter['chapter_name'],
                'chapter_number' => $chapter['chapter_number'],
                'content' => $chapter['content']
            );
        }

        exit(json_encode(array('status'=>true,'msg'=>'Success','data'=>$data,'is_full'=>$isFull,"story_id"=>$storyId)));
    }

    public function actionStory(){
        $lastId = (int)Yii::app()->request->getParam('last_id',0);
        $limit = (int) Yii::app()->request->getParam('limit',20);
        $offset = (int)Yii::app()->request->getParam('offset',0);
        $type = trim(CHtml::encode(Yii::app()->request->getParam('type','quotev')));
        $categoryId = (int)Yii::app()->request->getParam('category',0);

        if(!in_array($type,array('quotev','story'))){
            exit(json_encode(array('status'=>false,'msg'=>'Invalid param','data'=>null)));
        }

        if($type == 'quotev') {
            $stories = QuotevStoryModel::model()->getStoryWithLastId($lastId, $limit, $offset, null, null, null, 'id ASC');
        }else{
            $stories = StoryModel::model()->getStoryWithLastId($lastId,$limit,$offset,null,null,null,'id ASC',$categoryId);
        }

        if(empty($stories)){
            exit(json_encode(array(
                'status' => true,
                'msg' => 'Empty story',
                'data' => null
            )));
        }

        $data = array();
        foreach($stories as $story){
            $data[] = array(
                'id' => $story['id'],
                'story_name' => $story['story_name'],
                'description' => $story['description'],
            );
        }
        exit(json_encode(array('status'=>true,'msg'=>'Success','data'=>$data)));

    }

    public function actionSearch(){
        $name = trim(CHtml::encode(Yii::app()->request->getParam('name')));
        $type = trim(CHtml::encode(Yii::app()->request->getParam('type','quotev')));
        if(empty($name) || !in_array($type,array('quotev','story'))){
            exit(json_encode(array('status'=>false,'msg'=>'Invalid param','data'=>null)));
        }

        $criteria = new CDbCriteria();
        $criteria->addSearchCondition('story_name',$name);
        $criteria->limit(20);
        if($type == 'quotev') {
            $stories = QuotevStoryModel::model()->findAll($criteria);
        }
        if(empty($stories)){
            exit(json_encode(array(
                'status' => true,
                'msg' => 'Empty story',
                'data' => null
            )));
        }

        $data = array();
        foreach($stories as $story){
            $data[] = array(
                'id' => $story['id'],
                'story_name' => $story['story_name'],
                'description' => $story['description'],
            );
        }
        exit(json_encode(array('status'=>true,'msg'=>'Success','data'=>$data)));

    }
}

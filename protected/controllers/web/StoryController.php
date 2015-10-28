<?php
class StoryController extends Controller{
    public function actionView(){
        $slug = trim(Yii::app()->request->getParam('slug',null));
        $limit = 50;
        if(!empty($slug)){
            $story = StoryModel::model()->getStoryBySlug($slug);
        }

        if(empty($slug) || empty($story)){
            $this->forward('index/error');
            Yii::app()->end();
        }
        $table = 'chapter_'.substr($story->story_slug,0,2);

        $chapter = new ChapterModel();
        $total = $chapter->countChapterByStoryId($table,$story->id);
        $pager = new CPagination($total);
        $pager->setPageSize($limit);

        $chapters = $chapter->getChapterByStoryId($table,$story->id,50,$pager->getOffset(),'id,chapter_number,chapter_slug,chapter_name');
        $storyAuthor = StoryModel::model()->getStoryByAuthor($story->author);
        $this->render('view',compact('pager','story','chapters','storyAuthor'));
    }

    public function actionDetail(){
        $chaperId = Yii::app()->request->getParam('id');
        $prefix = Yii::app()->request->getParam('prefix');
        $table = 'chapter_'.$prefix;

        //lay chpater info
        $chapter = new ChapterModel();
        $chapterInfo = $chapter->getChapterById($table,$chaperId);
        if(empty($chapterInfo)){
            $this->forward('index/error');
            Yii::app()->end();
        }

        //get story Info
        $story = StoryModel::model()->findByPk($chapterInfo['story_id']);

        $this->render('detail',compact('story','chapterInfo'));
    }
}
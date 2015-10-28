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
        $total = $chapter->countChapterByStory($table,$slug);
        $pager = new CPagination($total);
        $pager->setPageSize($limit);

        $chapters = $chapter->getChapterByStory($table,$slug,50,$pager->getOffset(),'id,chapter_number,chapter_slug,chapter_name');

        $this->render('view',compact('pager','story','chapters'));
    }
}
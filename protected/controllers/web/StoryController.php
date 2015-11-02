<?php
class StoryController extends Controller{
    public function init(){
        parent::init();
        $this->layout = 'application.views.web.layouts.main';
    }
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

        //lay next va previous chapter
        $chapterIds = array($chapterInfo['chapter_number']-1,$chapterInfo['chapter_number']+1);
        $otherChapter = $chapter->getOtherChapterByChapterNumber($table,$chapterInfo['story_id'],$chapterIds);
        $previous = $next = null;
        if(!empty($otherChapter)) {
            foreach ($otherChapter as $r) {
                if ($r['chapter_number'] == $chapterIds[0]) {
                    $previous = $r;
                } else if ($r['chapter_number'] == $chapterIds[1]) {
                    $next = $r;
                }
            }
        }

        //get story Info
        $story = StoryModel::model()->findByPk($chapterInfo['story_id']);

        $this->render('detail',compact('story','chapterInfo','previous','next'));
    }

    public function actionAjax(){
        $type = Yii::app()->request->getParam('type','full');
        $cate = Yii::app()->request->getParam('category',null);

        $isFull = null;
        $isHot = false;
        if($type == 'full'){
            $isFull = 'Full';
            $title = 'Truyện FULL';
        }else{
            $isHot = true; //khi co hot thi chuyen thanh true
            $title = 'Truyện HOT';
        }
        $stories = StoryModel::model()->getStoryByCategory($cate,10,
            0,'id,category_name,category_slug,story_name,story_slug,lastest_chapter,hot,status', $isHot,$isFull,'sorder ASC');

        $this->renderPartial('ajax',compact('stories','title'));
    }

    public function actionLastest(){
        Yii::import("application.vendors.Hashids.*");

        $slug = Yii::app()->request->getParam('slug');
        $hashStr =  Yii::app()->request->getParam('code');
        $hashStrId = substr($hashStr, 2);
        $prefix =  substr($hashStr, 0,2);
        $table = 'chapter_'.$prefix;
        $hashids = new Hashids(Yii::app()->params["hash_url"]);
        $parse = $hashids->decode($hashStrId);
        $storyId = $parse[0];
        //lay chpater info
        $chapter = new ChapterModel();
        $chapterInfo = $chapter->getChapterBySlug($table,$storyId);
        if(empty($chapterInfo)){
            $this->forward('index/error');
            Yii::app()->end();
        }

        //lay next va previous chapter
        $chapterIds = array($chapterInfo['chapter_number']-1,$chapterInfo['chapter_number']+1);
        $otherChapter = $chapter->getOtherChapterByChapterNumber($table,$chapterInfo['story_id'],$chapterIds);
        $previous = $next = null;
        if(!empty($otherChapter)) {
            foreach ($otherChapter as $r) {
                if ($r['chapter_number'] == $chapterIds[0]) {
                    $previous = $r;
                } else if ($r['chapter_number'] == $chapterIds[1]) {
                    $next = $r;
                }
            }
        }

        //get story Info
        $story = StoryModel::model()->findByPk($chapterInfo['story_id']);

        $this->render('detail',compact('story','chapterInfo','previous','next'));
    }
}
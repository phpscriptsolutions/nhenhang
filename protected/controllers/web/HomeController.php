<?php
class HomeController extends Controller{
    public function actionIndex(){
        $this->layout = 'application.views.web.layouts.main';
        //$db = new ChapterModel();
        //$user = $db->getChapterByStory('chapter_50','50-Sac-Thai-Fifty-Shades-of-Grey',12,0,'id,chapter_name,chapter_slug');
        $hotStories = StoryModel::model()->getStoryByCategory();
        $fullStories = StoryModel::model()->getFullStoryByCategory();
        $this->render('index',compact('hotStories','fullStories'));
    }

    public function actionCategory(){
        $id = Yii::app()->request->getParam('id',1);
        $isHot = Yii::app()->request->getParam('hot',null);
        $limit = 32;
        if(empty($isHot)){
            $isHot = false;
        }else{
            $isHot = true;
        }
        //lay thong tin categroy
        $category = CategoryModel::model()->findByPk($id);

        if(empty($category)){
            $this->forward('index/error');
            Yii::app()->end();
        }

        $total = StoryModel::model()->countStoryByCategoryId($id,null, $isHot);
        $pager = new CPagination($total);
        $pager->setPageSize($limit);

        $stories = StoryModel::model()->getStoryByCategoryId($id,$limit,
            $pager->getOffset(),'id,category_name,category_slug,story_name,story_slug,lastest_chapter,hot,status', $isHot);

        $this->render('category',compact('total','pager','stories','category','isHot'));
    }
}
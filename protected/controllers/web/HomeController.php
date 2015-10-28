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
        $categorySlug = Yii::app()->request->getParam('category','ngon-tinh');
        $isHot = Yii::app()->request->getParam('hot',null);
        $limit = 32;
        if(empty($isHot)){
            $isHot = false;
        }else{
            $isHot = true;
        }
        //lay thong tin categroy
        $category = CategoryModel::model()->find('category_slug=:category_slug',array(':category_slug'=>$categorySlug));

        if(empty($category)){
            $this->forward('index/error');
            Yii::app()->end();
        }

        $total = StoryModel::model()->countStoryByCategory($categorySlug,null, $isHot);
        $pager = new CPagination($total);
        $pager->setPageSize($limit);

        $stories = StoryModel::model()->getStoryByCategory($categorySlug,$limit,
            $pager->getOffset(),'id,category_name,category_slug,story_name,story_slug,lastest_chapter,hot,status', $isHot);

        $this->render('category',compact('total','pager','stories','category','isHot'));
    }
}
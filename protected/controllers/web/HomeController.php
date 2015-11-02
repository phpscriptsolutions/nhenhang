<?php
class HomeController extends Controller{
    public function actionIndex(){
        $this->layout = 'application.views.web.layouts.main';
        //$db = new ChapterModel();
        //$user = $db->getChapterByStory('chapter_50','50-Sac-Thai-Fifty-Shades-of-Grey',12,0,'id,chapter_name,chapter_slug');
        $hotStories = StoryModel::model()->getStoryByCategory(null,12,0,null,true,null,'sorder ASC');
        $fullStories = StoryModel::model()->getFullStoryByCategory(null,12,0,null,false,'sorder ASC');
        $this->render('index',compact('hotStories','fullStories'));
    }

    public function actionSearch(){
        $q = Yii::app()->request->getParam('q',null);
        if(empty($q)){
            $this->redirect(Yii::app()->getBaseUrl(true));
        }

        $limit = 32;
        $total = StoryModel::model()->countSearchByName($q);
        $pager = new CPagination($total);
        $pager->setPageSize($limit);

        $stories = StoryModel::model()->getSearchByName($q,$limit,
            $pager->getOffset());

        $this->render('search',compact('total','pager','stories','q'));
    }

    public function actionCategory(){
        $categorySlug = Yii::app()->request->getParam('category','ngon-tinh');
        $isHot = Yii::app()->request->getParam('hot',null);
        $isFull = Yii::app()->request->getParam('s',null);
        $limit = 32;
        if(empty($isHot)){
            $isHot = false;
        }else{
            $isHot = true;
        }
        //lay thong tin categroy
        if(!in_array($categorySlug,array('truyen-hot','truyen-full','truyen-moi'))) {
            $category = CategoryModel::model()->find('category_slug=:category_slug', array(':category_slug' => $categorySlug));
        }else if($categorySlug == 'truyen-hot'){
            $category = new CategoryModel();
            $category->category_name = 'Truyện Hot';
            $category->category_slug = 'hot';
            $categorySlug = null;
        }else if($categorySlug == 'truyen-full' || $categorySlug == 'truyen-moi'){
            $category = new CategoryModel();
            $category->category_name = 'Truyện Full';
            $category->category_slug = 'full';
            $categorySlug = null;
        }

        if(empty($category)){
            $this->forward('index/error');
            Yii::app()->end();
        }
        $total = StoryModel::model()->countStoryByCategory($categorySlug,null, $isHot,$isFull);
        $pager = new CPagination($total);
        $pager->setPageSize($limit);

        $stories = StoryModel::model()->getStoryByCategory($categorySlug,$limit,
            $pager->getOffset(),'id,category_name,category_slug,story_name,story_slug,lastest_chapter,hot,status', $isHot,$isFull,'sorder ASC');

        $this->render('category',compact('total','pager','stories','category','isHot'));
    }
}
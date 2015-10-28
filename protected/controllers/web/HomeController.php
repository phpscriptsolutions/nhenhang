<?php
class HomeController extends Controller{
    public function actionIndex(){
        $this->layout = 'application.views.web.layouts.main';
        //$db = new ChapterModel();
        //$user = $db->getChapterByStory('chapter_50','50-Sac-Thai-Fifty-Shades-of-Grey',12,0,'id,chapter_name,chapter_slug');
        $hotStories = StoryModel::model()->getHotStoryByCategory();
        $fullStories = StoryModel::model()->getFullStoryByCategory();
        $this->render('index',compact('hotStories','fullStories'));
    }
}
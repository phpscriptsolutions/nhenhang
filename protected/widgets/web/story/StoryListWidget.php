<?php
class StoryListWidget extends CWidget
{

    public $stories = null;
    public $title = 'Danh Sách Truyện';
    public $link = null;
    public $options = array();
    public function run()
    {
        $this->render('storyList', array(
            'stories'=>$this->stories,
            'title' => $this->title,
            'link' => $this->link,
            'options'=>  $this->options,
        ));
    }
}
<?php
class StoryListWidget extends CWidget
{

    public $stories = null;
    public $title = 'Danh Sách Truyện';
    public $options = array();
    public function run()
    {
        $this->render('storyList', array(
            'stories'=>$this->stories,
            'title' => $this->title,
            'options'=>  $this->options,
        ));
    }
}
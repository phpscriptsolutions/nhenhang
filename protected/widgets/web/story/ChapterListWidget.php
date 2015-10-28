<?php
class ChapterListWidget extends CWidget
{

    public $story = null;
    public $pager = null;
    public $storyRelate = null;
    public $chapters = null;
    public $options = array();
    public function run()
    {
        $this->render('chapterList', array(
            'story'=>$this->story,
            'chapters' => $this->chapters,
            'options'=>  $this->options,
        ));
    }
}
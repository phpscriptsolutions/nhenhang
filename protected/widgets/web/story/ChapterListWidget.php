<?php
class ChapterListWidget extends CWidget
{

    public $story = null;
    public $storyAuthor = null;
    public $pager = null;
    public $chapters = null;
    public $options = array();
    public function run()
    {
        $this->render('chapterList', array(
            'story'=>$this->story,
            'chapters' => $this->chapters,
            'options'=>  $this->options,
            'storyAuthor' => $this->storyAuthor,
            'pager'=>$this->pager,
        ));
    }
}
<?php
class ChapterDetailWidget extends CWidget
{

    public $story = null;
    public $pager = null;
    public $chapter = null;
    public $options = array();
    public function run()
    {
        $storyAuthor = StoryModel::model()->getStoryByAuthor($this->story->author);
        $this->render('chapterDetail', array(
            'story'=>$this->story,
            'chapter' => $this->chapter,
            'options'=>  $this->options,
            'storyAuthor' => $storyAuthor,
            'pager'=>$this->pager,
        ));
    }
}
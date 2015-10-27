<?php
$this->widget('application.widgets.web.story.StoryListWidget',
    array(
        'stories'=>$hotStories,
        'title'=>'Truyện HOT',
    ));

$this->widget('application.widgets.web.story.StoryListWidget',
    array(
        'stories'=>$fullStories,
        'title'=>'Truyện FULL',
    ));
?>
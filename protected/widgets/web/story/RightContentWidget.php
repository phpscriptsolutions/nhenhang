<?php
class RightContentWidget extends CWidget
{

    public $story = null;
    public $options = array();
    public function run()
    {
        $this->render('rightContent', array(
            'story'=>$this->story,
            'options'=>  $this->options,
        ));
    }
}
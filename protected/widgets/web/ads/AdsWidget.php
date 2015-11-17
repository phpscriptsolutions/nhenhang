<?php
class AdsWidget extends CWidget
{

    public $data = null;
    public $title = 'Kho tải App/Game';
    public $link = null;
    public $options = array();
    public function run()
    {
        $this->render('listAds', array(
            'data'=>$this->data,
            'title' => $this->title,
            'link' => $this->link,
            'options'=>  $this->options,
        ));
    }
}
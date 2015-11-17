<?php
class AdsWidget extends CWidget
{

    public $listAds = null;
    public $title = 'Danh Sách Ứng Dụng';
    public $link = null;
    public $options = array();
    public function run()
    {
        $this->render('listAds', array(
            'stories'=>$this->stories,
            'title' => $this->title,
            'link' => $this->link,
            'options'=>  $this->options,
        ));
    }
}
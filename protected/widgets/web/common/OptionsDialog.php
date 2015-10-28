<?php
class OptionsDialog extends CWidget
{
    public $url_share='#';
    public $content_type='';
    public $content_id=0;
    public $disReport = false;
    public function init()
    {
        /*$cs=Yii::app()->getClientScript();
        $cs->registerScript('options-plus',"
            $('.options-plus .btn-plus').live('click', function(){
                $('.options-plus .options-dialog').toggleClass('open');
            })
        ");*/
        parent::init();
    }
    public function run()
    {
        $this->render('options_dialog');
    }
}
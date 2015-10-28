<?php
class ContentExCollWidget extends CWidget
{
    public $intro_size = 100;
    public $content='';
    public $id=1;
    public function run()
    {
        $content = $this->content;
        $validContent = NULL;
        if(!empty($content)) {
            $p = new CHtmlPurifier();
            $p->options = array('HTML.ForbiddenElements' => array('p', 'span', 'ul', 'li', 'div', 'a', 'script'));
            $validContent = $p->purify(trim($content));

            $cs = Yii::app()->clientScript;
            $cs->registerScript('ct_ex_coll' . $this->id, "
            $('.see_full').click(function(){
                var t=$(this).closest('.ct-desc');
                $(this).closest('.desc_short').addClass('hide');
                t.find('.desc_full').removeClass('hide');
            })
            $('.see_intro').click(function(){
                var t=$(this).closest('.ct-desc');
                $(this).closest('.desc_full').addClass('hide');
                t.find('.desc_short').removeClass('hide');
            })", CClientScript::POS_END);
        }
        $this->render('_ct_ex_coll', array('content'=>$validContent));
    }
}
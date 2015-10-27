<?php
/**
 * Created by PhpStorm.
 * User: tiennt
 * Date: 08/07/2015
 * Time: 15:04
 */
class StatiticsWidget extends CWidget{
    public $id;
    public $category; //song|album|video
    public $type = 'played_count'; //play_count|download_count

    public function init(){
        $cs = Yii::app()->getClientScript();
        $cs->registerScript(__CLASS__.'#'.$this->type.'-'.$this->id,
            "function getCountView(){
                $.ajax({
                    type:'POST',
                    data:'id={$this->id}&type={$this->type}&category={$this->category}',
                    url:'/mix/getTotalView',
                    success:function(data){
                        $('#{$this->type}-{$this->category}-{$this->id}').text(data);
                    }
                });
            }", CClientScript::POS_END);

        $cs->registerScript(__CLASS__.'#'.$this->type.'-'.$this->id.'-call',"getCountView();",CClientScript::POS_READY);
        parent::init();
    }

    public function run(){
        echo CHtml::openTag('div',array('id'=>$this->type.'-'.$this->category.'-'.$this->id));
        echo CHtml::closeTag('div');
    }
}
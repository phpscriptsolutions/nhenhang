<?php
/**
 * Created by PhpStorm.
 * User: tiennt
 * Date: 08/07/2015
 * Time: 15:04
 */
class FauvoriteWidget extends CWidget{
    public $id;
    public $category; //song|album|video
    public $type = 'fauvorite'; //play_count|download_count

    public function init(){
        $cs = Yii::app()->getClientScript();
        $cs->registerScript(__CLASS__.'#'.$this->type.'-'.$this->id,
            "function getCountFa(){
                $.ajax({
                    type:'GET',
                    dataType:'json',
                    data:'id={$this->id}&type={$this->type}&category={$this->category}',
                    url:'/mix/getTotalFauvorite',
                    beforeSend: function(){
                        $('#{$this->type}-{$this->category}-{$this->id}').html('<img width=\"16\" src=\"/web/images/ajax-loader.gif\" />');
                    },
                    success:function(data){
                        $('#{$this->type}-{$this->category}-{$this->id}').html(data.data);
                    }
                });
            }", CClientScript::POS_END);

        $cs->registerScript(__CLASS__.'#'.$this->type.'-'.$this->id.'-call',"getCountFa();",CClientScript::POS_READY);
        parent::init();
    }

    public function run(){
        echo CHtml::openTag('div',array('id'=>$this->type.'-'.$this->category.'-'.$this->id));
        echo CHtml::closeTag('div');
    }
}
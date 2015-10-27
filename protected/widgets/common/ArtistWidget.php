<?php
class ArtistWidget extends CWidget{
    public $id;
    public $type = 'artist-info';

    public function init(){
        $cs = Yii::app()->getClientScript();
        $cs->registerScript(__CLASS__.'#'.$this->type.'-'.$this->id,
            "function getArtistView(){
                $.ajax({
                    type:'POST',
                    data:{id:{$this->id},type:'{$this->type}'},
                    url:'/ajax/findArtistInfo',
                    success:function(data){
                        $('#{$this->type}-{$this->id}').html(data);
                    }
                });
            }", CClientScript::POS_END);
        $cs->registerScript(__CLASS__.'#'.$this->type.'-'.$this->id,"getArtistView();",CClientScript::POS_READY);
        parent::init();
    }

    public function run(){
        echo CHtml::openTag('div',array('id'=>$this->type.'-'.$this->id));
        echo CHtml::closeTag('div');
    }
}
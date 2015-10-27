<?php
class MyPlaylistWidget extends CWidget{
    public $id;
    public $type = 'album'; //play_count|download_count

    public function init(){
        if($this->type=='video'){
            $action ='like_unlike_video';
        }else{
            $action ='like_unlike_album';
        }
        $cs = Yii::app()->getClientScript();
        $cs->registerScript(__CLASS__.'#'.$this->type.'-'.$this->id,
            "
            var idhd = 'myplaylist-{$this->type}-{$this->id}';
            $('.mp-saved').live('mouseover', function(){
                $(this).addClass('mp-close');
                $(this).removeClass('mp-saved');
            })
            $('.mp-close').live('mouseout', function(){
                $(this).addClass('mp-saved');
                $(this).removeClass('mp-close');
            })
            $('.mp-save').live('click', function(){
                updateFaMyplaylist();
            })
            $('.mp-close').live('click', function(){
                updateFaMyplaylist();
            })
            function callbackActionLikeAlbum(){
                setTimeout(isMyPlaylist,500);
            }
            function updateFaMyplaylist()
            {
                $.ajax({
                    url: '/ajax',
                    type:'POST',
                    dataType:'json',
                    data: {action:'".$action."',id:{$this->id}},
                    beforeSend: function(){
                        $('#'+idhd).html('<img width=\"16\" src=\"/web/images/ajax-loader.gif\" />');
                    },
                    success:function(data){
                        if(data.errorCode==2){
                            addDialoglogin_form_dialog();
                            jQuery('#login_form_dialog').dialog('open');
                            $('#'+idhd).html('<a class=\"mp-save\"><span class=\"mp-icon\"></span></a>');
                        }else if(data.errorCode=='liked'){
                            $('#'+idhd).html('<a class=\"mp-saved\"><span class=\"mp-icon\"></span></a>');
                        }else{
                            $('#'+idhd).html('<a class=\"mp-save\"><span class=\"mp-icon\"></span></a>');
                        }
                    }
                })
            }
            function isMyPlaylist(){
                $.ajax({
                    type:'GET',
                    dataType:'json',
                    data:{id:".$this->id.",type:'".$this->type."'},
                    url:'/mix/isMyPlaylist',
                    beforeSend: function(){
                        $('#'+idhd).html('<img width=\"16\" src=\"/web/images/ajax-loader.gif\" />');
                    },
                    success:function(data){
                        if(data.code){
                            $('#'+idhd).html('<a class=\"mp-saved\"><span class=\"mp-icon\"></span></a>');
                        }else{
                            $('#'+idhd).html('<a class=\"mp-save\"><span class=\"mp-icon\"></span></a>');
                        }
                    }
                });
            }", CClientScript::POS_END);

        $cs->registerScript(__CLASS__.'#'.$this->type.'-'.$this->id.'-call',"isMyPlaylist();",CClientScript::POS_READY);
        parent::init();
    }

    public function run(){
        echo CHtml::openTag('div',array('class'=>'mfa','id'=>'myplaylist-'.$this->type.'-'.$this->id));
        echo CHtml::closeTag('div');
    }
}
<?php
class NotifyMessageWidget extends CWidget
{
    public $msg='';
    public $type='song';
    public function run()
    {
        if($this->type=='song'){
            $msg = Yii::t('web',$this->msg,array('{content}'=>'Bài hát'));
        }elseif($this->type=='video'){
            $msg = Yii::t('web',$this->msg,array('{content}'=>'Video'));
        }elseif($this->type=='album'){
            $msg = Yii::t('web',$this->msg,array('{content}'=>'Album'));
        }else{
            $msg = $this->msg;
        }
        echo '<div class="limit_content"><div class="msglimit">'.$msg.'</div></div>';
    }
}
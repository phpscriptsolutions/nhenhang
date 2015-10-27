<?php
Yii::import('zii.widgets.jui.CJuiDialog');

/**
 * AjaxDialog displays a dialog widget with create form using the given controller path.
 *
 * AjaxDialog extends the CJuiDialog widget
 *
 * To use this widget, you may insert the following code in a view:
 * <pre>
 * $this->beginWidget('ext.webcare.widgets.AjaxDialog', array(// the dialog
 *      'id' => 'MyDialog',
 *      'linkText' => 'Create New MyClass', // The Button which is placed for opening the dialog
 *      'url' => array('controller/create'), // controller/action usually create
 *      'parentElementSelector' => '#selectElement',  // the parent select element in which the data returned will be populated
 *     // additional javascript options for the dialog plugin
 *     'options'=>array(
 *         'title'=>'Dialog box 1',
 *         'autoOpen'=>false,
 *     ),
 * ));
 *
 * $this->endWidget('application.widgets.AjaxDialog');
 *
 * </pre>
 * 
 * Don't forget to change your controller's create action like the following
 * <pre>
 * if ($model->save()) {
 *      if (Yii::app()->request->isAjaxRequest && Yii::app()->request->isPostRequest) {
 *          echo CJSON::encode(
 *                  array(
 *                      'status' => 'success',
 *                      'div' => 'MyClass Record successfully added',
 *                      'newObj' => array('id'=>$model->id,'value'=>$model->title),
 *                  )
 *          );
 *          Yii::app()->end();
 *      } else {
 *          $this->redirect(array('view', 'id' => $model->id));
 *      }
 *  }
 * </pre>
 * 
 * And before the following code
 * 
 * <pre>
 * $this->render('create', array(
 *      'model' => $model,
 * ));
 * </pre>
 * Add the following
 * <pre>
 * if (Yii::app()->request->isAjaxRequest) {
 *   echo CJSON::encode(array(
 *     'status'=>'failure', 
 *     'div'=>$this->renderPartial('_form', array('model'=>$model), true)));
 *   Yii::app()->end();
 * }
 *
 *      
 * 
 * </pre>
 */
class AjaxDialog extends CJuiDialog {

    public $url;
    public $parentElementSelector; // it is the selector in which we would like to update the data after closing.
    public $linkText; // text to be diplayed over the create button

//    public $tagName='div'; //it's inherited

    /**
     * Renders the open tag of the dialog.
     * This method also registers the necessary javascript code.
     */
    public function init() {
        $id = $this->getId();
        if (isset($this->htmlOptions['id'])) {
            $id = $this->htmlOptions['id'];
        } else {
            $this->htmlOptions['id'] = $id;
        }
        /*$this->options['position'] = array(
            'my'=>"top",
            'at'=>'top+250',
        );*/
        $options = CJavaScript::encode($this->options);
        Yii::app()->getClientScript()->registerScript(__CLASS__ . '#' . $id, "jQuery('#{$id}').dialog($options);");
        Yii::app()->getClientScript()->registerScript('#close_'.$id, "jQuery('.ui-widget-overlay').live('click', function(){ jQuery('#$id').dialog('close');});", CClientScript::POS_END);

        if(!empty($this->linkText)) {
            echo CHtml::link($this->linkText, 'javascript:void(0);', // label
                array(
                    'onclick' => "{addDialog{$id}(); jQuery('#{$id}').dialog('open');}"));
        }

        echo CHtml::openTag($this->tagName, $this->htmlOptions) . "\n";
        
        echo CHtml::openTag('div', array('class' => 'resultContainer'));
        echo CHtml::closeTag('div');
        
        echo CHtml::script('function addDialog'.$id.'(){'
                . CHtml::ajax(array(
                    'url' => $this->url,
                    'data' => "js:$(this).serialize()",
                    'type' => 'post',
                    'dataType' => 'json',
                    'beforeSend'=>"function(){
                        //overlay_show();
                        //jQuery('#{$id} div.resultContainer').html('<div class=\"loading\"></div>');
                        jQuery('#{$id}').append('<span class=\"loading_popup\"></span>');
                    }",
                    'success' => "function(data)
                    {
                    jQuery('#{$id} .loading_popup').remove();
                        if (data.status == 'failure') {
                            // Here is the trick: on submit-> once again this function!
                            jQuery('#{$id} div.resultContainer').html(data.div);
                            jQuery('#{$id} div.resultContainer form').submit(addDialog{$id});
                        }else if(data.status == 'success') {
                            jQuery('#{$id} div.resultContainer').html(data.div);
                            setTimeout(\"jQuery('#{$id}').dialog('close') \",500);
                        }else if(data.status == 'redirect'){
                            location.href=data.url;
                        }else if(data.status == 'login_ajax'){
                            setTimeout(\"jQuery('#{$id}').dialog('close') \",0);
                            jQuery('#user-menu-box').html(data.data);
                            jQuery('#user_id').text(data.user_id);
                            if(data.last_action=='720p'){
                                jwplayer().setCurrentQuality(0);
                            }else if(data.last_action=='like_album'){
                                if(typeof(callbackActionLikeAlbum) == 'function'){
                                    callbackActionLikeAlbum();
                                }
                            }
                        }else if(data.status == 'verifyCode'){
                            addDialogverifyCode_form_dialog();
                            jQuery('#forgotpass_form_dialog').dialog('close');
                            jQuery('#verifyCode_form_dialog').dialog('open');
                        }else if(data.status == 'renewPass'){
                            addDialogrenewPass_form_dialog();
                            jQuery('#verifyCode_form_dialog').dialog('close');
                            jQuery('#renewPass_form_dialog').dialog('open');
                        }

                    }",
                    'complete'=>"function(){
                        overlay_hide();
                    }"
                )) . ';
                return false;}');
    }

    /**
     * Renders the close tag of the dialog.
     */
    public function run() {
        echo CHtml::closeTag($this->tagName);
    }

}

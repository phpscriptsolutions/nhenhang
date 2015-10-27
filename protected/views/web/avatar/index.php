<style>
    #uploadFile{
        opacity: 1;
    }
</style>
<h2>Upload your icon</h2>
<?php
$url = Yii::app()->createUrl('/avatar/cover');
$this->widget('ext.EAjaxUpload.EAjaxUpload',
    array(
        'id'=>'uploadFile',
        'config'=>array(
            'action'=>Yii::app()->createUrl("avatar/uploadCover"),
            'allowedExtensions'=>array("jpg","jpeg","png"),//array("jpg","jpeg","gif","exe","mov" and etc...
            'sizeLimit'=>10*1024*1024,// maximum file size in bytes
            'onComplete'=>"js:function(id, fileName, responseJSON){
                                    if(responseJSON.success){
                                        var params = {'file':responseJSON.filename};
                                        jQuery.ajax({
                                              'url':'".$url."',
                                              'data':params,
                                              'type':'GET',
                                              'cache':false,
                                              'dataType':'JSON',
                                              'beforeSend':function(){
                                                jQuery('.artist .awall').append('<div class=\"loading\"></div>');
                                              },
                                              'success':function(result){
                                                    jQuery('.artist .awall .loading').remove();
                                                    console.log(result);
                                                    jQuery('#cover-img').attr('src',result.imgSrc);
                                                    if(result.status){
                                                        //NhacVnCoreJs.addNotify(result.msg);
                                                        //location.reload();
                                                    }else{
                                                        alert(result.msg);
                                                    }
                                              },
                                              'complete':function(){
                                                    //jQuery('#overlay, #box_load').hide();
                                              }
                                          });
                                    }else{
                                        alert('Có lỗi trong quá trình upload hoặc dung lượng file vượt quá giới hạn cho phép là 5mb.');
                                    }
                                }",
        )
    )); ?>
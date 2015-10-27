<div class="content-body">

     
    
    <?php
    $this->widget('ext.xupload.XUploadWidget', array(
        'url' => $this->createUrl("Phone/upload", array("parent_id" => 'tmp')),
        'model' => $uploadModel,
        'attribute' => 'file',
        'options' => array(
            'onComplete' => 'js:function (event, files, index, xhr, handler, callBack) {
				                                           						if(handler.response.error){
				                                           							alert(handler.response.msg);
				                                           							$("#files").html("<tr><td><label></label></td><td><div class=\'wrr\'>' . Yii::t('admin', 'Lỗi upload') . ' :"+handler.response.msg+"</div></td></tr>");
				                                           						}else{				                                           							
                                                                                                                                $("#source_name").val(handler.response.name);     
                                                                                                                                $("#upload-form #sub-button").show();
				                                           						}				                                                               
				                                                            }'
        )
    ));
    ?>
    
    <?php    
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/jquery-1.8.1.min.js");
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/jquery.quicksearch.js");
Yii::app()->clientScript->registerScript('search', "
$(document).ready(function(){
    $('#date_filter').click(function(){
        $('.ui-daterangepickercontain').css('top',$('#date_filter').offset().top + 20);
        $('.ui-daterangepickercontain').css('left',$('#date_filter').offset().left);
    });
    
    $('input#quicksearch').quicksearch('#group .igroup');

    $('#exist_group_filter').click(function(){   
        $('#group').toggle();
        $('#quicksearch').toggle();
    });
    
    $('#km_filter').click(function(){   
        $('#register_phone_filter').attr('checked', false);
    });
    
    $('#register_phone_filter').click(function(){   
        $('#km_filter').attr('checked', false);
    });
    
    $('#upload-form #sub-button').hide();
        $('#yw7 li:nth-child(4)').hide();
        $('#yw7 li:nth-child(3) a').click(function(e){
            $(this).target = '_blank';
            var c = confirm('Bạn có muốn lọc những số ĐT đã đăng ký hay không?');
            if(c){
                var link = $('#yw7 li:nth-child(4) a').attr('href');
                window.open(link);
            }
            else{
                window.open($(this).attr('href'));
            }
            return false;    
        });

    });

");
?>
    <div class="row">

        <?php
        $form = $this->beginWidget(
                'CActiveForm', array(
            'id' => 'upload-form',
            'enableAjaxValidation' => false,
            'action' => Yii::app()->controller->createUrl("Group/upload"),
                )
        );
        ?>

        <p class="note"><?php echo yii::t('SpamModule', 'Lưu ý: Chỉ hỗ trợ file .xls (Excell 2003)'); ?></p>
        <br>

        <table style="float: left;">
            <tr>
                <td><span for="km_filter"><b>Chỉ lấy những số ĐT được hưởng KM</b></span></td>
                <td><?php echo CHtml::checkBox('km_filter', false);
        ?></td>
            </tr>
            
            <tr>
                <td><span for="register_phone_filter"><b>Lọc những số ĐT đã đăng kí</b></span></td>
                <td><?php echo CHtml::checkBox('register_phone_filter', true);
        ?></td>
            </tr>
            <tr>
                <td><span for="exist_group_filter"><b>Lọc những số ĐT đã thuộc các nhóm đã có</b></span></td>
                <td><?php echo CHtml::checkBox('exist_group_filter', false);
        ?></td>
            </tr>
            <tr>
                <td>                    
			<fieldset>
				<input id="quicksearch" type="text" style="display:none;margin:4px 0" name="search" value="" id="id_search" placeholder="Tìm nhóm Spam" autofocus />
			</fieldset>                    
                </td>
            </tr>
            
        </table>
        <br>
        <div id="group" style="display:none;height: 200px; overflow-y: scroll; width: 100%; padding-top: 10px; border-top: 2px solid rgb(51, 51, 51);">
                    <?php
                    $cri = new CDbCriteria;                  
                    $cri->condition = " id != $group_id";
                    $group = GroupModel::model()->findAll($cri);
                    foreach($group as $gr){
                        echo "<div class='igroup'><input type='checkbox' name='group_list[]' value={$gr->id} ><span>".$gr->name."</span></div>";
                        
                    }
                    ?>
                </div>

        <br>
        <table style="float:left;width:100%;">
            <tr>
                <td style="vertical-align: middle;" ><b><?php echo CHtml::label(Yii::t('admin', 'Thời gian'), "") ?></b></td>
                <td style="vertical-align: middle;">
                    <div class="row created_time" style="position: relative;float:left"> 
                        <?php
                        $this->widget('ext.daterangepicker.input', array(
                            'name' => 'date_filter',
                            'value' => '',//date("m/d/Y"),
                        ));
                        ?>
                    </div>  
                </td>
            </tr>
        </table>
        

        <div class="row buttons" id="sub-button">
            <?php
            echo CHtml::hiddenField("source_name");
            echo CHtml::hiddenField("group_id", $group_id);
            echo CHtml::submitButton('Submit');
            ?>
        </div>

        <?php
        $this->endWidget();
        ?>

    </div><!-- form -->
</div>
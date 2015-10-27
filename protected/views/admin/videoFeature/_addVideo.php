<?php 
Yii::app()->clientScript->registerCss("","
	#jobDialog .summary{display:none}
");
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'jobDialog',
                'options'=>array(
                    'title'=>Yii::t('job','Danh sách Video'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'650px',
                    'height'=>'auto',
                ),
                ));


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('admin-song-model-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<fieldset class="p10">
	<legend>
		<div class="title-box b">
    		<?php echo CHtml::link('Tìm kiếm','#',array('class'=>'search-button')); ?>
    	</div>	
    </legend>
    <div class="search-form" style="display:block">
		<div class="wide form">
			<?php $form=$this->beginWidget('CActiveForm', array(
				'action'=>Yii::app()->createUrl($this->route),
				'method'=>'get',
			)); ?>
			<div class="row fl cln">
				<label><?php echo Yii::t("admin", "Tên")?></label>
				<?php echo $form->textField($videoModel,'name',array()); ?>
			</div>
			<div class="row fl cln">
				<label><?php echo Yii::t("admin", "Thể loại")?></label>
		        <?php
					$category = CMap::mergeArray(
										array(''=> "Tất cả"),
										   CHtml::listData($categoryList, 'id', 'name')
										);
					$searchByGenre = isset($_GET["AdminVideoModel"]["genre_id"])?$_GET["AdminVideoModel"]["genre_id"]:0;
	                echo CHtml::dropDownList("AdminVideoModel[genre_id]", $searchByGenre, $category,array('class'=>'h25') ) 
	             ?>
	             			
			</div>
			
			<div class="row buttons fl" style="text-align: center;">
				<?php echo CHtml::submitButton('Search'); ?>
			</div>
			
			<?php $this->endWidget(); ?>		
		</div>
	
	</div><!-- search-form -->
	    
</fieldset>

<?php
$form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl('videoFeature/addVideo'),
    'method'=>'post',
    'htmlOptions'=>array('class'=>'popupform'),
));

$columns = array(
    
                array(
                    'class'                 =>  'CCheckBoxColumn',
                    'selectableRows'        =>  2,
                    'checkBoxHtmlOptions'   =>  array('name'=>'cid[]'),
                    'headerHtmlOptions'   =>  array('width'=>'50px','style'=>'text-align:left'),
                    'id'                    =>  'cid',
                    'checked'               =>  'false'
                ),
                'id',
		        'name',
                array(
	                    'header'=>'Artist',
	                    'name' => 'artist_name',
                    ),
            );
            
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-song-model-grid',
	'dataProvider'=>$videoModel->search(),	
	'columns'=> $columns,
));

echo CHtml::ajaxSubmitButton(Yii::t('admin','Chọn'),CHtml::normalizeUrl(array('videoFeature/addVideo','id'=>0)),array('success'=>'js: function(data) {
                        $("#jobDialog").dialog("close");
                        window.location.reload( true );
                    }'),array('id'=>'closeJobDialog'));
echo CHtml::hiddenField("object", $object);
echo CHtml::hiddenField("collect_id", $collect_id);
echo CHtml::button(Yii::t('admin','Bỏ qua'),array("onclick"=>'$("#jobDialog").dialog("close");'));
$this->endWidget();
$this->endWidget('zii.widgets.jui.CJuiDialog');

?>

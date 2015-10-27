<?php
$this->pageLabel = Yii::t("admin","Danh sách Collection show trên trang chủ web");


Yii::app()->clientScript->registerScript('search', "
window.reorder_col = function()
{
   $.post('".$this->createUrl('collection/reorderwebhome')."',$('.adminform').serialize(), function(data){
        alert('Cập nhật thành công');
   		window.location.reload();
   });
}
");

Yii::app()->getClientScript()->registerCssFile( Yii::app()->theme->baseUrl."/css/jquery.autocomplete.css");
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl."/js/jquery.autocomplete.js");
$link = Yii::app()->createUrl("collection/autoComplete");

$script = <<<EOD
   	    $(document).ready(function() {
	   	    $('#cl_name').autocomplete('{$link}', {
				width: 260,
				matchContains: true,
				mustMatch: true,
				selectFirst: false
			});
			$("#cl_name").result(function(event, data, formatted) {
	   	    	if(data){
	   	    		$("#cl_name").val(data[0]);
					$("#cl_id").val(data[1]);
				}
			});
   	    });
EOD;
Yii::app()->clientScript->registerScript("auto",$script, CClientScript::POS_HEAD);

?>

<div style="display:block" class="search-form">
<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl("collection/addwebhome"),
	'method'=>'get',
)); ?>

	<div class="row">
		<label for="AdminCollectionModel_name">Name</label>
		<input type="text" id="cl_name" name="cl_name" maxlength="255" size="60" />
		<input type="hidden" id="cl_id" name="cl_id" />
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Add'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
</div>

<?php
$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
	'method'=>'post',
	'htmlOptions'=>array('class'=>'adminform',),
));
echo '<div class="op-box">';
echo '<div style="display:none">'.CHtml::checkBox ("all-item",false,array("value"=>$model->count(),"style"=>"width:30px")).'</div>';
echo '</div>';

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'collection-model-grid',
	'dataProvider'=>$model->search('web_home_page'),
	'columns'=>array(
            array(
                    'class'                 =>  'CCheckBoxColumn',
                    'selectableRows'        =>  2,
                    'checkBoxHtmlOptions'   =>  array('name'=>'cid[]'),
                    'headerHtmlOptions'   =>  array('width'=>'50px','style'=>'text-align:left'),
                    'id'                    =>  'cid',
                    'checked'               =>  'false'
                ),

		'name',
		'code',
		'type',
        array(
				'header'=>'Sắp xếp'.CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/css/img/save_icon.png"),"",array("onclick"=>"reorder_col()") ),
				'value'=> 'CHtml::textField("sorder[$data->id]", $data->web_home_page,array("size"=>1))',
				'type' => 'raw',
				'htmlOptions'=>array('align'=>'center')
		),
		'id',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view} {update} {delete}',
			'buttons'=>array(
				'delete'=>array(
					'url'=>'Yii::app()->createUrl("/collection/disCollectinWeb", array("id"=>$data->id))'
				)
			)
		),
	),
));
$this->endWidget();

?>

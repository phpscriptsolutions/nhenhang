<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<table>
		<tr><td>
			<div class="">
			<?php echo $form->label($model,'user_phone'); ?>
			<?php echo $form->textField($model,'user_phone',array('size'=>16,'maxlength'=>16)); ?>
			</div>
			</td>
		</tr>
		<tr>
			<td>
		        <div class="row created_time">
	            <?php echo $form->label($model,'created_time'); ?>
		            <?php 
				       $this->widget('ext.daterangepicker.input',array(
				            'name'=>'AdminUserSubscribeModel[created_time]',
				       		'value'=>isset($_GET['AdminUserSubscribeModel']['created_time'])?$_GET['AdminUserSubscribeModel']['created_time']:'',
				        ));
				     ?>
		        </div> 
			</td>
		</tr>
	</table>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
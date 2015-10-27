<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
	</div>

    <div class="row">
    <?php echo $form->label($model,'Channel'); ?>
	<?php
        $channels = AdminConfigModel::CHANNEL;
        $arr_ = explode(',',",".$channels);
        foreach($arr_ as $channel)
            $arr_channels[$channel] = $channel;
        $channel = Yii::app()->request->getParam('channel','');   
        echo CHtml::dropDownList("ConfigModel[channel]", $channel, $arr_channels)
    ?>
    </div>
    
    <?php if(UserAccess::checkAccess('ConfigSupperIndex')): ?>
    <div class="row">
    <?php echo $form->label($model,'Category'); ?>
	<?php
        $categorys = AdminConfigModel::CATEGORY;
        $arr_ = explode(',',",".$categorys);
        foreach($arr_ as $category)
            $arr_categorys[$category] = $category;
        $category = Yii::app()->request->getParam('category','basic');   
        echo CHtml::dropDownList("ConfigModel[category]", $category, $arr_categorys)
    ?>
    </div>
    <?php endif;?>
    
    <div class="row">
    <?php echo $form->label($model,'Type'); ?>
	<?php
        $types = AdminConfigModel::TYPE;
        $arr_ = explode(',',",".$types);
        foreach($arr_ as $type)
            $arr_types[$type] = $type;
        $type = Yii::app()->request->getParam('type','');   
        echo CHtml::dropDownList("ConfigModel[type]", $type, $arr_types)
    ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
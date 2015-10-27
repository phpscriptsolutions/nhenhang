<?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'admin-video-model-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('enctype' => 'multipart/form-data')
                ));
?>

	<input type="file" name="file_upload" />
	<br />
	<input type="submit" value="upload" />
	<?php if(!empty($error))
			echo "<pre>";print_r($error);echo "</pre>";
		?>
<?php $this->endWidget(); ?>

<?php
$this->pageLabel = Yii::t('admin', "Thông tin tài khoản");

$state = Yii::app()->request->getParam('_state');
$linkUpdate = Yii::app()->createUrl("adminUser/profile",array('_state' => $state,'_layout'=>'update'));

$this->menu=array(
		array('label'=>Yii::t('admin', 'Cập nhật thông tin tài khoản'), 'url'=>$linkUpdate),
);

if($state){
	$msg = "";
	if($this->expiredPass > 2){
		$msg = "Your password has expired using the time allowed (90 days). ";
	}
	$msg .= "You need to change your password to continue using this CMS system.";
	echo '<div class="notify-change-pass"><p>'.$msg.'</p></div>';
}


?>


<div class="content-body">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(                
                array(
                    'label'=>'Tên đăng nhập',
                    'value'=>$model['username'],
                ),
				'email',
                array(
                    'label'=>'Tên đầy đủ',
                    'value'=>$model['fullname'],
                ),
                array(
                    'label'=>'Số điện thoại',
                    'value'=>$model['phone'],
                ),
				array(
						'label'=>'Tên CP',
						'value'=>($cp)?$cp->name:'',
				),
                array(
                    'label'=>'Công ty',
                    'value'=>$model['company'],
                ),              
	),
)); ?>
</div>
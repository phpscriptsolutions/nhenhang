<?php
$this->pageLabel = Yii::t('admin', "Thống kê tùy chỉnh");

$this->menu=array(	
	//array('label'=>Yii::t('admin','Export'), 'url'=>array('reports/song','export'=>1)),
);

	$cs=Yii::app()->getClientScript();
	$cs->registerCoreScript('jquery');
	$cs->registerCoreScript('bbq');
	$baseScriptUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/gridview';
	$cssFile=$baseScriptUrl.'/styles.css';
	$cs->registerCssFile($cssFile);
	
$sqlData = array();
foreach($data as $item){
	$sqlData[$item->id]= $item->sql_string;
}
?>
<script type="text/javascript">
//<!--
	var sqlData = <?php echo json_encode($sqlData)?>;
	function chosenCmd(el){
		if(sqlData[el.value]){
			$("#cmd_sql").val(sqlData[el.value]);
			$("#cmd_id").val(el.value);
		}
	}
	function runCmd()
	{
		var cmdId = parseInt($("#cmd_id").val());
		if(cmdId < 1){
			alert("Chưa chọn lệnh");
			return false;
		}else{
			url = '<?php echo Yii::app()->createUrl("reportsCustom/index")?>&id='+cmdId;
			window.location = url;
		}
	}
//-->
</script>

<div class="title-box">
    <?php echo CHtml::link('Lựa chọn truy vấn','#',array('class'=>'search-button')); ?>
</div>

<div class="search-form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route),
		'method'=>'post',
	)); ?>
	<table width="100%" cellpadding="4" cellspacing="4">
		<tr>
			<td style="vertical-align: top;padding: 3px"><b><?php echo CHtml::label(Yii::t('admin','Tên lệnh'), "") ?></b></td>
			<td style="vertical-align: middle;padding: 3px">
				<?php 
					$data = CMap::mergeArray(
                                    array(0 => "Chọn lệnh"),
                                    CHtml::listData($data, 'id', 'name')
								);
					echo CHtml::dropDownList("cmd_id", $sqlObj->id, $data,array('onchange'=>'chosenCmd(this)'))  
				?>	
				&nbsp;&nbsp;
				<?php echo CHtml::button("Thực hiện",array('onclick'=>'runCmd()')); ?>
			</td>
		</tr>
		<tr>
			<td style="vertical-align:top;padding: 3px"><b><?php echo CHtml::label(Yii::t('admin','Mã lệnh'), "") ?></b></td>
			<td style="vertical-align: middle;padding: 3px" >
				<?php echo CHtml::textArea("cmd_sql",$sqlObj->sql_string,array('cols'=>50,'rows'=>'8'));  ?>				
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td style="vertical-align: middle;">
				&nbsp;
				<?php echo CHtml::submitButton('Lưu lại'); ?>
				&nbsp;
				<span>
				 Với tên mới là
				 <?php echo CHtml::textField("cmd_new_name");  ?>
				 * ( Để trắng nếu muốn giữ nguyên tên )
				 </span> 			
			</td>
		</tr>
	</table>
	<?php $this->endWidget(); ?>

</div><!-- search-form -->

<?php if(!empty($errors)):?>
<div class="errorSummary">
<p><b>Xảy ra lỗi</b></p>
<?php 
foreach ($errors as $k=>$v){
	echo $v."<br />";
}
?>
</div>
<?php endif; ?>


<?php if(!empty($result)):?>
<div class="title-box">
    <a><?php echo Yii::t('admin','Kết quả thực hiện:');  ?></a> 
    <?php 
    $curentUrl =  Yii::app()->request->getRequestUri();
    for($i=0;$i<$link;$i++):
        $and = ($i>0)?("&part=".$i):"";
        ?>
    <a class="button" href="<?php echo $curentUrl.'&export=1'.$and ;?>">Export <?php echo $i;?></a>    
    <?php endfor; ?>
</div>
<div class="content-body grid-view" style="overflow: auto">
<p> Tổng số : <?php echo count($result) ?></p>
<?php 
	$cols = array();
	foreach($result[0] as $k=>$v){
		$cols[] = $k;
	}
?>
<table width="100%" class="items">
	<tr>
    	<?php foreach($cols as $col):?>
    	<th><?php echo $col?></th>
    	<?php endforeach;?>
	</tr>
	<?php foreach ($result as $res):?>
	<tr>
    	<?php foreach($cols as $col):?>
    	<td><?php echo $res[$col]?></td>
    	<?php endforeach;?>		
	</tr>
	<?php endforeach;?>
</table>

</div>
<?php endif;?>	


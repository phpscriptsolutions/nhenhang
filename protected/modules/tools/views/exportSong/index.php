<style>
    .button-column{
        width: 65px!important;
    }
    .link-column{
        width: 30px;
        text-align: center;
    }
</style>
<div class="title-box search-box">
    <?php echo CHtml::link('Tìm kiếm', '#', array('class' => 'search-button')); ?></div>

<div class="search-form">

    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
        'categoryList' => $categoryList,
        'cpList' => $cpList,
		'is_composer'=>$is_composer,
		'copyright'=>$copyright,
		'copyrightType'=>$copyrightType
    ));
    ?>
</div><!-- search-form -->
<?php 
echo '<div>Tổng số kết quả '.$count.'</div>';
if($count>0){
	echo '<div>Danh sách Export</div>';
	echo '<ul>';
	for ($i=1; $i<=$numPage; $i++){
		echo '<li><a href="'.Yii::app()->request->requestUri.'&export=1&page='.$i.'">export_'.$i.'</a></li>';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;';
	}
	echo '</ul>';
	
}?>
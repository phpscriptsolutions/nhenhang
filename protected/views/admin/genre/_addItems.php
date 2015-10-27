<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'jobDialog',
                'options'=>array(
                    'title'=>Yii::t('job','Danh sách bài hát'),
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


function reloadGrid(){

    //****************** reload the grid *****************
                        $('#inlist-zone').show();
                        $('#basic-zone').hide();
                        $('#fav-zone').hide();
                        var url = $('#inlist-info').attr('href');
                        if(!inlistzone){
                                $.ajax({
                                        type: 'GET',
                                        url: url,
                                        context: document.body,
                                        beforeSend:function(){
                                        },
                                        success: function(data){

                                                $('#inlist-zone').html(data);
                                                $('<script>').each(function(){
                                                        eval(this.innerHTML);
                                                });
                                                inlistzone = true;
                                        },
                                        complete:function(){
                                        },
                                        statusCode: {
                                                404: function() {
                                                alert('page not found');
                                                }
                                        } 

                                        });
                        };
                        $('li.active').removeClass('active');
                        $(this).parent().addClass('active');
                        return false;
}

$('.delete').live('click',function(){    
    setTimeout(function(){
    reloadGrid();

    },500);

});
");
?>

<div class="title-box search-box">
    <?php echo CHtml::link('Lọc trên danh sách','#',array('class'=>'search-button')); ?>
</div>

<div class="search-form" style="display:none">

<?php $this->renderPartial('_searchPopup',array(
	'model'=>$songModel,
    'categoryList'=>$categoryList,
    'cpList'=>$cpList,
)); ?>
</div>

<?php

$form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
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
		        'code',
		        'name',
                array(
	                    'header'=>'category',
	                    'name' => 'genre.name',
                    ),
                'artist_name',
            );
            
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-song-model-grid',
	'dataProvider'=>$songModel->search(),	
	'columns'=> $columns,
));

echo CHtml::hiddenField("genre_id",$playListId);

echo CHtml::ajaxSubmitButton(Yii::t('admin','Chọn'),CHtml::normalizeUrl(array('genre/addItems')),array('success'=>'js: function(data) {
                        $("#jobDialog").dialog("close");
                        inlistzone = false;
			///$("#inlist-info").click();
                        
                        reloadGrid();
                    }'),array('id'=>'closeJobDialog'));
echo CHtml::button(Yii::t('admin','Bỏ qua'),array("onclick"=>'$("#jobDialog").dialog("close");'));

$this->endWidget();

$this->endWidget('zii.widgets.jui.CJuiDialog');

?>

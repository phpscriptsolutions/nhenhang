<?php if($is_collection == 1): ?>
<a class="button" id="add-item" href="<?php echo $this->createUrl('genre/addItems',array('genre_id'=>$id)); ?>">
	<?php echo Yii::t('admin','Thêm bài hát'); ?>
</a> 
<?php
endif;?>
<style>
    .yiiPager .selected a, .yiiPager .active a{
        color: #111;
        font-weight: bold;
    }
    input[type="text"]{
        width:100px!important;
    }
    .yiiPager li {
        float: left;
        padding: 0 4px;
    }
</style>
<script>
$(document).ready(function(){
    var inlistzone = false;;
    $('.yiiPager li a').live('click',function() {
        $('#inlist-zone').show();
        $('#basic-zone').hide();
        $('#fav-zone').hide();
        var url = $(this).attr('href');
        if(!inlistzone){
            $.ajax({
                  type: "GET",
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
    });
});
</script>

<?php
$form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
	'method'=>'post',
	'htmlOptions'=>array('class'=>'adminform'),
));
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-genre-song-model-grid',
	'dataProvider'=>$listSong->simpleSearch($id),	
	'columns'=>array(
		'id',
        array(
        	'header'=>'Bài hát',
            'name' => 'name',
		),
		array(
	    		'header'=>Yii::t('admin','Sắp xếp') .CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/css/img/save_icon.png"),$this->createUrl('genre/reorderItems'),array("id"=>"reorder") ),
	            'value'=> 'CHtml::textField("sorder[$data->id]", $data->sorder,array("size"=>1))',
	            'type' => 'raw',
			),
		array(
	            'class'=>'CLinkColumn',
	            'header'=> Yii::t('admin','Hiển thị'),
	            'labelExpression'=>'($data->status==1)?CHtml::image(Yii::app()->request->baseUrl."/css/img/publish.png"):CHtml::image(Yii::app()->request->baseUrl."/css/img/unpublish.png")',
	            'urlExpression'=>'($data->status==1)?Yii::app()->createUrl("genre/unpublishItems",array("cid[]"=>$data->id)):Yii::app()->createUrl("genre/publishItems",array("cid[]"=>$data->id))',
	            'linkHtmlOptions'=>array(),
			),
		array(
			'class'=>'CButtonColumn',
			'header'=> Yii::t('admin','Xóa'),
			'template'=>'{delete}',
			'deleteButtonUrl'=>'Yii::app()->controller->createUrl("deleteItems",array("cid[]"=>$data->id))'
		),
	),
));

$this->endWidget();
<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
    <?php echo CHtml::encode($data->name); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('url')); ?>:</b>
    <?php echo CHtml::encode($data->url); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('start_time')); ?>:</b>
    <?php echo CHtml::encode($data->start_time); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('expired_time')); ?>:</b>
    <?php echo CHtml::encode($data->expired_time); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('image_file')); ?>:</b>
    <?php echo CHtml::encode($data->image_file); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
    <?php echo CHtml::encode($data->status); ?>
    <br />


</div>
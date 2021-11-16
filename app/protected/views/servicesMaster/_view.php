<?php
/* @var $this ServicesMasterController */
/* @var $data ServicesMaster */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('service_code')); ?>:</b>
	<?php echo CHtml::encode($data->service_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('service_description')); ?>:</b>
	<?php echo CHtml::encode($data->service_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vehical_type')); ?>:</b>
	<?php echo CHtml::encode($data->vehical_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_active')); ?>:</b>
	<?php echo CHtml::encode($data->is_active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('added_on')); ?>:</b>
	<?php echo CHtml::encode($data->added_on); ?>
	<br />


</div>
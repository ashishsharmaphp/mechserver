<?php
/* @var $this MechMasterController */
/* @var $data MechMaster */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mobile')); ?>:</b>
	<?php echo CHtml::encode($data->mobile); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pass')); ?>:</b>
	<?php echo CHtml::encode($data->pass); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('device_token')); ?>:</b>
	<?php echo CHtml::encode($data->device_token); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('os')); ?>:</b>
	<?php echo CHtml::encode($data->os); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('email_valid')); ?>:</b>
	<?php echo CHtml::encode($data->email_valid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mobile_valid')); ?>:</b>
	<?php echo CHtml::encode($data->mobile_valid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_active')); ?>:</b>
	<?php echo CHtml::encode($data->is_active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_busy')); ?>:</b>
	<?php echo CHtml::encode($data->is_busy); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_logged_in')); ?>:</b>
	<?php echo CHtml::encode($data->is_logged_in); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('added_on')); ?>:</b>
	<?php echo CHtml::encode($data->added_on); ?>
	<br />

	*/ ?>

</div>
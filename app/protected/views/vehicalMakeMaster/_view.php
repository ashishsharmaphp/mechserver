<?php
/* @var $this VehicalMakeMasterController */
/* @var $data VehicalMakeMaster */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('make')); ?>:</b>
	<?php echo CHtml::encode($data->make); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vehical_type')); ?>:</b>
	<?php echo CHtml::encode($data->vehical_type); ?>
	<br />


</div>
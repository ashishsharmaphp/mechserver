<?php
/* @var $this ServicesMasterController */
/* @var $model ServicesMaster */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'services-master-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'service_code'); ?>
		<?php echo $form->textField($model,'service_code',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'service_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'service_description'); ?>
		<?php echo $form->textField($model,'service_description',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'service_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vehical_type'); ?>
		<?php echo $form->textField($model,'vehical_type'); ?>
		<?php echo $form->error($model,'vehical_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_active'); ?>
		<?php echo $form->textField($model,'is_active'); ?>
		<?php echo $form->error($model,'is_active'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'added_on'); ?>
		<?php echo $form->textField($model,'added_on'); ?>
		<?php echo $form->error($model,'added_on'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
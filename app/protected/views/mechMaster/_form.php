<?php
/* @var $this MechMasterController */
/* @var $model MechMaster */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'mech-master-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('size' => 50, 'maxlength' => 50)); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'mobile'); ?>
        <?php echo $form->textField($model, 'mobile', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($model, 'mobile'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'pass'); ?>
        <?php echo $form->passwordField($model, 'pass', array('size' => 50, 'maxlength' => 50)); ?>
        <?php echo $form->error($model, 'pass'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'device_token'); ?>
        <?php echo $form->textArea($model, 'device_token', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'device_token'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'os'); ?>
        <?php echo $form->textField($model, 'os', array('size' => 50, 'maxlength' => 50)); ?>
        <?php echo $form->error($model, 'os'); ?>
    </div>

    <div class="control-group row" id="docBox">
        <label class="control-label">Select DP<span class="required">*</span></label>
        <div class="controls">
            <input type="file" id="txtFile" name="dp" accept=".jpeg,.jpg,.png">
        </div>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'email_valid'); ?>
        <?php echo $form->textField($model, 'email_valid'); ?>
        <?php echo $form->error($model, 'email_valid'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'mobile_valid'); ?>
        <?php echo $form->textField($model, 'mobile_valid'); ?>
        <?php echo $form->error($model, 'mobile_valid'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'is_active'); ?>
        <?php echo $form->textField($model, 'is_active'); ?>
        <?php echo $form->error($model, 'is_active'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'is_busy'); ?>
        <?php echo $form->textField($model, 'is_busy'); ?>
        <?php echo $form->error($model, 'is_busy'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'is_logged_in'); ?>
        <?php echo $form->textField($model, 'is_logged_in'); ?>
        <?php echo $form->error($model, 'is_logged_in'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'added_on'); ?>
        <?php echo $form->textField($model, 'added_on'); ?>
        <?php echo $form->error($model, 'added_on'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
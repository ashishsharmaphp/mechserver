<?php
/* @var $this MechMasterController */
/* @var $model MechMaster */

$this->breadcrumbs=array(
	'Mech Masters'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List MechMaster', 'url'=>array('index')),
	array('label'=>'Create MechMaster', 'url'=>array('create')),
	array('label'=>'Update MechMaster', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MechMaster', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MechMaster', 'url'=>array('admin')),
);
?>

<h1>View MechMaster #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'email',
		'mobile',
		'pass',
		'device_token',
		'os',
		'email_valid',
		'mobile_valid',
		'is_active',
		'is_busy',
		'is_logged_in',
		'added_on',
	),
)); ?>

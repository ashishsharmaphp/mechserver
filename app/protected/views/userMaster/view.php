<?php
/* @var $this UserMasterController */
/* @var $model UserMaster */

$this->breadcrumbs=array(
	'User Masters'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List UserMaster', 'url'=>array('index')),
	array('label'=>'Create UserMaster', 'url'=>array('create')),
	array('label'=>'Update UserMaster', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete UserMaster', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UserMaster', 'url'=>array('admin')),
);
?>

<h1>View UserMaster #<?php echo $model->id; ?></h1>

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
		'is_busy',
		'is_active',
		'is_logged_in',
		'added_on',
	),
)); ?>

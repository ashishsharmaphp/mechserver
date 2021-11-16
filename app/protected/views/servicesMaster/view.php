<?php
/* @var $this ServicesMasterController */
/* @var $model ServicesMaster */

$this->breadcrumbs=array(
	'Services Masters'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ServicesMaster', 'url'=>array('index')),
	array('label'=>'Create ServicesMaster', 'url'=>array('create')),
	array('label'=>'Update ServicesMaster', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ServicesMaster', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ServicesMaster', 'url'=>array('admin')),
);
?>

<h1>View ServicesMaster #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'service_code',
		'service_description',
		'vehical_type',
		'is_active',
		'added_on',
	),
)); ?>

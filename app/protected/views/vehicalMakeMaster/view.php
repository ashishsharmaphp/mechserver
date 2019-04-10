<?php
/* @var $this VehicalMakeMasterController */
/* @var $model VehicalMakeMaster */

$this->breadcrumbs=array(
	'Vehical Make Masters'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List VehicalMakeMaster', 'url'=>array('index')),
	array('label'=>'Create VehicalMakeMaster', 'url'=>array('create')),
	array('label'=>'Update VehicalMakeMaster', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete VehicalMakeMaster', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage VehicalMakeMaster', 'url'=>array('admin')),
);
?>

<h1>View VehicalMakeMaster #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'make',
		'vehical_type',
	),
)); ?>

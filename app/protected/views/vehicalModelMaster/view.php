<?php
/* @var $this VehicalModelMasterController */
/* @var $model VehicalModelMaster */

$this->breadcrumbs=array(
	'Vehical Model Masters'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List VehicalModelMaster', 'url'=>array('index')),
	array('label'=>'Create VehicalModelMaster', 'url'=>array('create')),
	array('label'=>'Update VehicalModelMaster', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete VehicalModelMaster', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage VehicalModelMaster', 'url'=>array('admin')),
);
?>

<h1>View VehicalModelMaster #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'make_id',
		'model',
	),
)); ?>

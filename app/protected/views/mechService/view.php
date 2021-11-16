<?php
/* @var $this MechServiceController */
/* @var $model MechService */

$this->breadcrumbs=array(
	'Mech Services'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List MechService', 'url'=>array('index')),
	array('label'=>'Create MechService', 'url'=>array('create')),
	array('label'=>'Update MechService', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MechService', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MechService', 'url'=>array('admin')),
);
?>

<h1>View MechService #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'mech_id',
		'service_id',
		'price',
		'comments',
		'added_on',
	),
)); ?>

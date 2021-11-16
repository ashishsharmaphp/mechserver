<?php
/* @var $this VehicalMakeMasterController */
/* @var $model VehicalMakeMaster */

$this->breadcrumbs=array(
	'Vehical Make Masters'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List VehicalMakeMaster', 'url'=>array('index')),
	array('label'=>'Create VehicalMakeMaster', 'url'=>array('create')),
	array('label'=>'View VehicalMakeMaster', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage VehicalMakeMaster', 'url'=>array('admin')),
);
?>

<h1>Update VehicalMakeMaster <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
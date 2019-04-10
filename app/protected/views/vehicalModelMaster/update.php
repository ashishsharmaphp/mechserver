<?php
/* @var $this VehicalModelMasterController */
/* @var $model VehicalModelMaster */

$this->breadcrumbs=array(
	'Vehical Model Masters'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List VehicalModelMaster', 'url'=>array('index')),
	array('label'=>'Create VehicalModelMaster', 'url'=>array('create')),
	array('label'=>'View VehicalModelMaster', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage VehicalModelMaster', 'url'=>array('admin')),
);
?>

<h1>Update VehicalModelMaster <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
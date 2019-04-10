<?php
/* @var $this MechMasterController */
/* @var $model MechMaster */

$this->breadcrumbs=array(
	'Mech Masters'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List MechMaster', 'url'=>array('index')),
	array('label'=>'Create MechMaster', 'url'=>array('create')),
	array('label'=>'View MechMaster', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage MechMaster', 'url'=>array('admin')),
);
?>

<h1>Update MechMaster <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
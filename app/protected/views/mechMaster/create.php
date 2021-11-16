<?php
/* @var $this MechMasterController */
/* @var $model MechMaster */

$this->breadcrumbs=array(
	'Mech Masters'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MechMaster', 'url'=>array('index')),
	array('label'=>'Manage MechMaster', 'url'=>array('admin')),
);
?>

<h1>Create MechMaster</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
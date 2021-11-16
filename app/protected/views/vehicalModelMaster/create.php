<?php
/* @var $this VehicalModelMasterController */
/* @var $model VehicalModelMaster */

$this->breadcrumbs=array(
	'Vehical Model Masters'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List VehicalModelMaster', 'url'=>array('index')),
	array('label'=>'Manage VehicalModelMaster', 'url'=>array('admin')),
);
?>

<h1>Create VehicalModelMaster</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
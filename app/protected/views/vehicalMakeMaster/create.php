<?php
/* @var $this VehicalMakeMasterController */
/* @var $model VehicalMakeMaster */

$this->breadcrumbs=array(
	'Vehical Make Masters'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List VehicalMakeMaster', 'url'=>array('index')),
	array('label'=>'Manage VehicalMakeMaster', 'url'=>array('admin')),
);
?>

<h1>Create VehicalMakeMaster</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
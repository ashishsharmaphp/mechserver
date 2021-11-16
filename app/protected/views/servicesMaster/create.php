<?php
/* @var $this ServicesMasterController */
/* @var $model ServicesMaster */

$this->breadcrumbs=array(
	'Services Masters'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ServicesMaster', 'url'=>array('index')),
	array('label'=>'Manage ServicesMaster', 'url'=>array('admin')),
);
?>

<h1>Create ServicesMaster</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
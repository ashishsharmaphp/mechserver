<?php
/* @var $this MechServiceController */
/* @var $model MechService */

$this->breadcrumbs=array(
	'Mech Services'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MechService', 'url'=>array('index')),
	array('label'=>'Manage MechService', 'url'=>array('admin')),
);
?>

<h1>Create MechService</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
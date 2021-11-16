<?php
/* @var $this ServicesMasterController */
/* @var $model ServicesMaster */

$this->breadcrumbs=array(
	'Services Masters'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ServicesMaster', 'url'=>array('index')),
	array('label'=>'Create ServicesMaster', 'url'=>array('create')),
	array('label'=>'View ServicesMaster', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ServicesMaster', 'url'=>array('admin')),
);
?>

<h1>Update ServicesMaster <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
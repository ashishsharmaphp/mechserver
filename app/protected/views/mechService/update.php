<?php
/* @var $this MechServiceController */
/* @var $model MechService */

$this->breadcrumbs=array(
	'Mech Services'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List MechService', 'url'=>array('index')),
	array('label'=>'Create MechService', 'url'=>array('create')),
	array('label'=>'View MechService', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage MechService', 'url'=>array('admin')),
);
?>

<h1>Update MechService <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
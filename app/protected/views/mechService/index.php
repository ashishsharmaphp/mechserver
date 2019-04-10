<?php
/* @var $this MechServiceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Mech Services',
);

$this->menu=array(
	array('label'=>'Create MechService', 'url'=>array('create')),
	array('label'=>'Manage MechService', 'url'=>array('admin')),
);
?>

<h1>Mech Services</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

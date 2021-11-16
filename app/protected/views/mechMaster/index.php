<?php
/* @var $this MechMasterController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Mech Masters',
);

$this->menu=array(
	array('label'=>'Create MechMaster', 'url'=>array('create')),
	array('label'=>'Manage MechMaster', 'url'=>array('admin')),
);
?>

<h1>Mech Masters</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

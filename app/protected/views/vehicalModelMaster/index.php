<?php
/* @var $this VehicalModelMasterController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Vehical Model Masters',
);

$this->menu=array(
	array('label'=>'Create VehicalModelMaster', 'url'=>array('create')),
	array('label'=>'Manage VehicalModelMaster', 'url'=>array('admin')),
);
?>

<h1>Vehical Model Masters</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

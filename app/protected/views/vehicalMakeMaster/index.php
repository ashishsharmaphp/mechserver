<?php
/* @var $this VehicalMakeMasterController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Vehical Make Masters',
);

$this->menu=array(
	array('label'=>'Create VehicalMakeMaster', 'url'=>array('create')),
	array('label'=>'Manage VehicalMakeMaster', 'url'=>array('admin')),
);
?>

<h1>Vehical Make Masters</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

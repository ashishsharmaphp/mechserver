<?php
/* @var $this ServicesMasterController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Services Masters',
);

$this->menu=array(
	array('label'=>'Create ServicesMaster', 'url'=>array('create')),
	array('label'=>'Manage ServicesMaster', 'url'=>array('admin')),
);
?>

<h1>Services Masters</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

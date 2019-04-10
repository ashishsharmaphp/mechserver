<?php
/* @var $this VouchersMasterController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Vouchers Masters',
);

$this->menu=array(
	array('label'=>'Create VouchersMaster', 'url'=>array('create')),
	array('label'=>'Manage VouchersMaster', 'url'=>array('admin')),
);
?>

<h1>Vouchers Masters</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

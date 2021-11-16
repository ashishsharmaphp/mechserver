<?php
/* @var $this VouchersMasterController */
/* @var $model VouchersMaster */

$this->breadcrumbs=array(
	'Vouchers Masters'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List VouchersMaster', 'url'=>array('index')),
	array('label'=>'Manage VouchersMaster', 'url'=>array('admin')),
);
?>

<h1>Create VouchersMaster</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
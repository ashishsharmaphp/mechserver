<?php
/* @var $this VouchersMasterController */
/* @var $model VouchersMaster */

$this->breadcrumbs=array(
	'Vouchers Masters'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List VouchersMaster', 'url'=>array('index')),
	array('label'=>'Create VouchersMaster', 'url'=>array('create')),
	array('label'=>'View VouchersMaster', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage VouchersMaster', 'url'=>array('admin')),
);
?>

<h1>Update VouchersMaster <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
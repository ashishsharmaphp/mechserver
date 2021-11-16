<?php
/* @var $this VouchersMasterController */
/* @var $model VouchersMaster */

$this->breadcrumbs=array(
	'Vouchers Masters'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List VouchersMaster', 'url'=>array('index')),
	array('label'=>'Create VouchersMaster', 'url'=>array('create')),
	array('label'=>'Update VouchersMaster', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete VouchersMaster', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage VouchersMaster', 'url'=>array('admin')),
);
?>

<h1>View VouchersMaster #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'code',
		'is_active',
	),
)); ?>

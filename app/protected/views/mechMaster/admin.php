<?php
/* @var $this MechMasterController */
/* @var $model MechMaster */

$this->breadcrumbs=array(
	'Mech Masters'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List MechMaster', 'url'=>array('index')),
	array('label'=>'Create MechMaster', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#mech-master-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Mech Masters</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'mech-master-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'email',
		'mobile',
		'pass',
		'device_token',
		/*
		'os',
		'email_valid',
		'mobile_valid',
		'is_active',
		'is_busy',
		'is_logged_in',
		'added_on',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

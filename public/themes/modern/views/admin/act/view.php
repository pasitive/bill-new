<?php
$this->breadcrumbs=array(
	'Акты'=>array('index'),
	$model->id,
);

$this->menu=array(
    array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Обновить', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы действительно хотите удалить эту запись?')),
);
?>

<h1>Просмотр</h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'client.name',
		'contract.number',
		'number',
		'sum',
		'period',
        array(
            'name' => 'file',
            'type' => 'raw',
            'value' => CHtml::link($model->file, $model->getFile()),
        ),
        'signed:boolean',
		'created_at',
		'updated_at',
	),
)); ?>

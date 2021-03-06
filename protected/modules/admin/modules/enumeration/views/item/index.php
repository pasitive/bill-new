<?php
$this->breadcrumbs=array(
	'Enumeration Items'=>array('index'),
	'Список',
);

$this->menu=array(
array('label'=>'Создать', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('enumeration-item-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1>Список</h1>

<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
'id'=>'enumeration-item-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		'enumeration_id',
		'name',
		'value',
		'is_default',
		'active',
		/*
		'order',
		'created_at',
		'updated_at',
		*/
array(
'class'=>'CButtonColumn',
),
),
)); ?>

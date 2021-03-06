<?php
$this->breadcrumbs = array(
    'Рекламные площадки' => array('index'),
    'Список',
);

$this->menu = array(
    array('label' => 'Создать', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('adv-platform-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Список</h1>

<?php echo CHtml::link('Расширенный поиск', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
		'model' => $model,
		'percentArray' => $percentArray,
	)); ?>
</div><!-- search-form -->

<?php
$advPlatforms = $model->search();
$advPlatforms->pagination->pageSize = 20;

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'adv-platform-grid',
    'dataProvider' => $advPlatforms,
    'filter' => null,
    'columns' => array(
        'id',
        array(
            'name' => 'name',
            'type' => 'raw',
            'value' => 'CHtml::link($data->name, array("/admin/advPlatform/view", "id" => $data->id))'
        ),
        array(
            'name' => 'work_percent',
            'type' => 'raw',
            'value' => 'Yii::app()->numberFormatter->formatPercentage($data->work_percent)',
        ),
		/*
        'created_at',
        'updated_at',
        */
		array(
            'class' => 'CButtonColumn',
        ),
    ),
)); ?>
